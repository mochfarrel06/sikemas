<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\QueueHistory;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queues = Queue::with('doctor')->get();
        } else {
            $queues = Queue::with('doctor')->where('user_id', $user->id)->get();
        }

        return response()->json([
            'data' => $queues,
        ], 200);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $userEmail = Auth::user()->email;

        $patient = Patient::where('email', $userEmail)->first();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan untuk pengguna ini.'
            ], 404);
        }

        // Cek apakah slot waktu sudah dipesan
        $existingQueue = Queue::where('doctor_id', $request->doctor_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($existingQueue) {
            return response()->json([
                'success' => false,
                'message' => 'Slot waktu ini sudah dipesan.'
            ], 409); // Conflict
        }

        // Simpan data antrean
        $queue = Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'keterangan' => $request->keterangan,
            'status' => 'booking',
            'is_booked' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Antrean berhasil ditambahkan.',
            'data' => $queue
        ], 201);
    }

    public function show_history()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queueHistories = QueueHistory::all();
        } else {
            $queueHistories = QueueHistory::where('user_id', $user->id)->get();
        }

        return response()->json([
            'data' => $queueHistories,
        ], 200);
    }

    public function show_dokter()
    {
        $doctors = Doctor::all();

        return response()->json([
            'data' => $doctors,
        ], 200);
    }

    public function show_poli()
    {
        $specializations = Specialization::all();

        return response()->json([
            'data' => $specializations,
        ], 200);
    }

    public function getDoctorSchedule($doctor_id, $date)
    {
        $dayOfWeek = Carbon::parse($date)->format('l');
        $doctorSchedules = DoctorSchedule::where('doctor_id', $doctor_id)
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

                $isBooked = Queue::where('doctor_id', $doctor_id)
                    ->where('tgl_periksa', $date)
                    ->where('start_time', $slotStart)
                    ->exists();

                $slots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'is_booked' => $isBooked,
                ];

                $start->addMinutes($waktuPeriksa + $waktuJeda);
            }
        }

        return response()->json([
            'doctor_id' => $doctor_id,
            'date' => $date,
            'slots' => $slots,
        ]);
    }
}
