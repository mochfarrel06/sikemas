<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\QueueStoreRequest;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\QueueHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class QueueController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin') {
            $queues = Queue::with('doctor')
                ->where('status', '!=', 'batal')
                ->where('status', '!=', 'selesai')
                ->get();
        } elseif ($role === 'dokter') {
            $queues = Queue::with('doctor')
                ->where('doctor_id', $user->doctor->id)
                ->where('status', '!=', 'batal')
                ->where('status', '!=', 'selesai')
                ->get();
        } else {
            $queues = Queue::with('doctor')
                ->where('user_id', $user->id)
                ->where('status', '!=', 'batal')
                ->where('status', '!=', 'selesai')
                ->get();
        }

        $userQueue = Queue::where('user_id', $user->id)->where('status', 'called')->first();

        return view('patient.queue.index', compact('queues', 'userQueue'));
    }

    public function create(Request $request)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($request->has('doctor_id') && $request->has('date')) {
            $doctorId = $request->input('doctor_id');
            $date = $request->input('date');

            $dayOfWeek = Carbon::parse($date)->format('l');
            $doctorSchedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('hari', $dayOfWeek)
                ->get();

            $slots = [];
            foreach ($doctorSchedules as $schedule) {
                $start = Carbon::parse($schedule->jam_mulai);
                $end = Carbon::parse($schedule->jam_selesai);

                $waktuPeriksa = $schedule->waktu_periksa ?? 30;
                $waktuJeda = $schedule->waktu_jeda ?? 10;

                while ($start->copy()->addMinutes($waktuPeriksa)->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($waktuPeriksa)->format('H:i');

                    $isBooked = Queue::where('doctor_id', $doctorId)
                        ->where('tgl_periksa', $date)
                        ->where('start_time', $slotStart)
                        ->exists();

                    $slots[] = [
                        'start' => $slotStart,
                        'end' => $slotEnd,
                        'is_booked' => $isBooked
                    ];

                    $start->addMinutes($waktuPeriksa + $waktuJeda);
                }
            }

            return response()->json($slots);
        }

        return view('patient.queue.create', compact('doctors', 'patients'));
    }

    public function store(QueueStoreRequest $request)
    {
        //dd($request->all());
        $userId = Auth::id();

        $userEmail = Auth::user()->email;

        $patient = Patient::where('email', $userEmail)->first();

        if (!$patient) {
            return redirect()->back()->withErrors(['error' => 'Data pasien tidak ditemukan untuk pengguna ini.']);
        }

        // Cek apakah slot waktu sudah dipesan
        $existingQueue = Queue::where('doctor_id', $request->doctor_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($existingQueue) {
            return redirect()->back()->withErrors(['error' => 'Slot waktu ini sudah dipesan.']);
        }

        // Simpan data antrean
        Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'keterangan' => $request->keterangan,
            'waktu_mulai' => $request->start_time,
            'waktu_selesai' => $request->end_time,
            // 'urutan' => $newUrutan,
            'status' => 'booking',
            'is_booked' => true
        ]);

        return redirect()->route('data-patient.queue.index')->with('success', 'Antrean berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        try {
            $queue = Queue::findOrFail($id);
            $userId = Auth::id();

            // QueueHistory::create([
            //     'queue_id' => $queue->id,
            //     'user_id' => $userId,
            //     'doctor_id' => $queue->doctor_id,
            //     'patient_id' => $queue->patient_id,
            //     'tgl_periksa' => $queue->tgl_periksa,
            //     'start_time' => $queue->start_time,
            //     'end_time' => $queue->end_time,
            //     'keterangan' => $queue->keterangan,
            //     'status' => 'batal',
            //     'is_booked' => $queue->is_booked,
            // ]);

            // $queue->delete();

            $queue->update([
                'status' => 'batal',
                'start_time' => null,
                'end_time' => null,
            ]);

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data pasien']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function callPatient($id)
    {
        $queue = Queue::findOrFail($id);
        // Kirim event ke WebSocket atau gunakan sesi untuk menampilkan alert ke pasien
        $queue->status = 'called';
        $queue->save();
        return response()->json(['status' => 'success', 'message' => 'Pasien telah dipanggil']);
    }

    public function checkQueueStatus()
    {
        $queue = Queue::where('user_id', auth()->id())->where('status', 'called')->first();

        if ($queue) {
            return response()->json(['called' => true]);
        } else {
            return response()->json(['called' => false]);
        }
    }

    public function selesaiPeriksa($id)
    {
        $queue = Queue::findOrFail($id);
        $userId = Auth::id();
        $queue->status = 'selesai';

        QueueHistory::create([
            'queue_id' => $queue->id,
            'user_id' => $userId,
            'doctor_id' => $queue->doctor_id,
            'patient_id' => $queue->patient_id,
            'tgl_periksa' => $queue->tgl_periksa,
            'start_time' => $queue->start_time,
            'end_time' => $queue->end_time,
            'keterangan' => $queue->keterangan,
            'status' => $queue->status,
            'is_booked' => $queue->is_booked,
        ]);

        $queue->save();
        return response()->json(['status' => 'success', 'message' => 'Antrean pasien ini telah selesai']);
    }

    public function periksaPasien($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->status = 'periksa';

        $queue->save();

        $phone = $queue->patient->no_hp;
        $message = "Halo, pasien dengan nama {$queue->patient->nama_depan} Bisa periksa sekarang";


        $response = Http::withHeaders([
            'Authorization' => 'QPwX1ySyYbPhmV4MAzJ8', // Ganti dengan API Key Fonnte
            'Content-Type'  => 'application/json',
        ])->post('https://api.fonnte.com/send', [
            'target'      => $phone,
            'message'     => $message,
            'countryCode' => '62', // Indonesia
        ]);

        $fonnteResponse = $response->json();

        // Kirim response JSON ke JavaScript
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil melakukan pemanggil antrean pasien.',
            'fonnte' => $fonnteResponse
        ]);
    }

    public function batalAntrean(string $id)
    {
        try {
            $queue = Queue::findOrFail($id);

            $queue->update([
                'status' => 'batal',
                'start_time' => null,
                'end_time' => null,
            ]);

            $phone = $queue->patient->no_hp;
            $message = "Halo, pasien dengan nama {$queue->patient->nama_depan} {$queue->patient->nama_belakang} antrean anda tanggal {$queue->tgl_periksa} pada pukul " .
                Carbon::parse($queue->waktu_mulai)->format('H:i') . " - " .
                Carbon::parse($queue->waktu_selesai)->format('H:i') . " kami batalkan";


            $response = Http::withHeaders([
                'Authorization' => 'QPwX1ySyYbPhmV4MAzJ8', // Ganti dengan API Key Fonnte
                'Content-Type'  => 'application/json',
            ])->post('https://api.fonnte.com/send', [
                'target'      => $phone,
                'message'     => $message,
                'countryCode' => '62', // Indonesia
            ]);

            $fonnteResponse = $response->json();

            // Kirim response JSON ke JavaScript
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil membatalkan antrean pasien.',
                'fonnte' => $fonnteResponse
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $queue = Queue::findOrFail($id);

        return view('patient.queue.show', compact('queue'));
    }

    public function createAntreanKhusus(Request $request)
    {
        $user = auth()->user();
        $doctor = Doctor::where('user_id', $user->id)->first(); // Sesuaikan jika tabelnya berbeda

        $doctorId = $doctor->id;
        $patients = Patient::all();

        if ($request->has('date')) {
            $date = $request->input('date');
            $dayOfWeek = Carbon::parse($date)->format('l');

            $doctorSchedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('hari', $dayOfWeek)
                ->get();

            $slots = [];
            foreach ($doctorSchedules as $schedule) {
                $start = Carbon::parse($schedule->jam_mulai);
                $end = Carbon::parse($schedule->jam_selesai);
                $waktuPeriksa = $schedule->waktu_periksa ?? 30;
                $waktuJeda = $schedule->waktu_jeda ?? 10;

                while ($start->copy()->addMinutes($waktuPeriksa)->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($waktuPeriksa)->format('H:i');

                    $isBooked = Queue::where('doctor_id', $doctorId)
                        ->where('tgl_periksa', $date)
                        ->where('start_time', $slotStart)
                        ->exists();

                    $slots[] = [
                        'start' => $slotStart,
                        'end' => $slotEnd,
                        'is_booked' => $isBooked
                    ];

                    $start->addMinutes($waktuPeriksa + $waktuJeda);
                }
            }

            return response()->json($slots);
        }

        return view('patient.queue.createAntreanKhusus', compact('doctorId', 'patients', 'doctor'));
    }

    public function storeAntreanKhusus(Request $request)
    {
        //dd($request->all());

        // Validasi request
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'tgl_periksa' => 'required|array',
            'tgl_periksa.*' => 'date|after_or_equal:today',
            'start_time' => 'required|array',
            'start_time.*' => 'required',
            'end_time' => 'required|array',
            'end_time.*' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        // Loop untuk menyimpan multiple appointment
        foreach ($request->tgl_periksa as $index => $tgl_periksa) {
            $existingQueue = Queue::where('doctor_id', $request->doctor_id)
                ->where('tgl_periksa', $tgl_periksa)
                ->where('start_time', $request->start_time[$index])
                ->exists();

            if ($existingQueue) {
                return redirect()->back()->withErrors(['error' => "Slot waktu $tgl_periksa - {$request->start_time[$index]} sudah dipesan."]);
            }

            Queue::create([
                'user_id' => $request->user_id,
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
                'tgl_periksa' => $tgl_periksa,
                'start_time' => $request->start_time[$index],
                'end_time' => $request->end_time[$index],
                'keterangan' => $request->keterangan,
                'status' => 'booking',
                'is_booked' => true
            ]);
        }

        return redirect()->route('data-patient.queue.index')->with('success', 'Antrean berhasil ditambahkan.');
    }

    public function createAntreanAdmin(Request $request)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($request->has('doctor_id') && $request->has('date')) {
            $doctorId = $request->input('doctor_id');
            $date = $request->input('date');

            $dayOfWeek = Carbon::parse($date)->format('l');
            $doctorSchedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('hari', $dayOfWeek)
                ->get();

            $slots = [];
            foreach ($doctorSchedules as $schedule) {
                $start = Carbon::parse($schedule->jam_mulai);
                $end = Carbon::parse($schedule->jam_selesai);

                $waktuPeriksa = $schedule->waktu_periksa ?? 30;
                $waktuJeda = $schedule->waktu_jeda ?? 10;

                while ($start->copy()->addMinutes($waktuPeriksa)->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($waktuPeriksa)->format('H:i');

                    $isBooked = Queue::where('doctor_id', $doctorId)
                        ->where('tgl_periksa', $date)
                        ->where('start_time', $slotStart)
                        ->exists();

                    $slots[] = [
                        'start' => $slotStart,
                        'end' => $slotEnd,
                        'is_booked' => $isBooked
                    ];

                    $start->addMinutes($waktuPeriksa + $waktuJeda);
                }
            }

            return response()->json($slots);
        }

        return view('patient.queue.createAntreanAdmin', compact('doctors', 'patients'));
    }

    public function storeAntreanAdmin(QueueStoreRequest $request)
    {
        //dd($request->all());
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'tgl_periksa' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        // Cek apakah slot waktu sudah dipesan
        $existingQueue = Queue::where('doctor_id', $request->doctor_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($existingQueue) {
            return redirect()->back()->withErrors(['error' => 'Slot waktu ini sudah dipesan.']);
        }

        $patient = Patient::findOrFail($request->patient_id);
        $userId = $patient->user_id;

        // Simpan data antrean
        Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'keterangan' => $request->keterangan,
            'waktu_mulai' => $request->start_time,
            'waktu_selesai' => $request->end_time,
            'status' => 'booking',
            'is_booked' => true
        ]);

        return redirect()->route('data-patient.queue.index')->with('success', 'Antrean berhasil ditambahkan.');
    }
}
