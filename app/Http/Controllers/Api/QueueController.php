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
use Illuminate\Support\Facades\DB;

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
    
        // Jika user mengirim start_time dan end_time (manual booking)
        if ($request->start_time && $request->end_time) {
            $existingQueue = Queue::where('doctor_id', $request->doctor_id)
                ->where('tgl_periksa', $request->tgl_periksa)
                ->where('start_time', $request->start_time)
                ->exists();
    
            if ($existingQueue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Slot waktu ini sudah dipesan.'
                ], 409);
            }
    
            // Simpan dengan slot manual
            $queue = Queue::create([
                'user_id' => $userId,
                'doctor_id' => $request->doctor_id,
                'patient_id' => $patient->id,
                'tgl_periksa' => $request->tgl_periksa,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'waktu_mulai' => $request->start_time,
                'waktu_selesai' => $request->end_time,
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
    
        // AUTO SLOT ASSIGNMENT - Cari slot pertama yang tersedia
        \Log::info('DEBUG: Mulai mencari slot otomatis', [
            'doctor_id' => $request->doctor_id,
            'tgl_periksa' => $request->tgl_periksa
        ]);
    
        $availableSlot = $this->findFirstAvailableSlot($request->doctor_id, $request->tgl_periksa);
    
        if (!$availableSlot) {
            // Debug info tambahan
            $debugInfo = $this->getDebugInfo($request->doctor_id, $request->tgl_periksa);
            
            \Log::error('DEBUG: Tidak ada slot tersedia', $debugInfo);
            
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada slot yang tersedia untuk tanggal tersebut.',
                'debug_info' => $debugInfo // Hapus ini di production
            ], 409);
        }
    
        // Simpan dengan slot otomatis
        $queue = Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $availableSlot['start_time'],
            'end_time' => $availableSlot['end_time'],
            'waktu_mulai' => $availableSlot['start_time'],
            'waktu_selesai' => $availableSlot['end_time'],
            'keterangan' => $request->keterangan,
            'status' => 'booking',
            'is_booked' => true
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Antrean berhasil ditambahkan dengan slot otomatis.',
            'data' => $queue,
            'slot_info' => [
                'start_time' => $availableSlot['start_time'],
                'end_time' => $availableSlot['end_time']
            ]
        ], 201);
    }
    
    /**
     * Method untuk debug info
     */
    private function getDebugInfo($doctorId, $tanggalPeriksa)
    {
        $dayOfWeek = \Carbon\Carbon::parse($tanggalPeriksa)->format('l');
        
        $dayMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $hari = $dayMapping[$dayOfWeek] ?? $dayOfWeek;
    
        // Cek apakah dokter ada
        $doctor = \App\Models\Doctor::find($doctorId);
        
        // Cek jadwal dokter
        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('hari', $hari)
            ->first();
    
        // Cek semua jadwal dokter
        $allSchedules = DoctorSchedule::where('doctor_id', $doctorId)->get();
    
        // Cek queue yang sudah ada
        $existingQueues = Queue::where('doctor_id', $doctorId)
            ->where('tgl_periksa', $tanggalPeriksa)
            ->get();
    
        return [
            'doctor_exists' => $doctor ? true : false,
            'doctor_id' => $doctorId,
            'tanggal_periksa' => $tanggalPeriksa,
            'day_of_week' => $dayOfWeek,
            'hari_indonesia' => $hari,
            'schedule_found' => $schedule ? true : false,
            'schedule_data' => $schedule,
            'all_doctor_schedules' => $allSchedules,
            'existing_queues_count' => $existingQueues->count(),
            'existing_queues' => $existingQueues
        ];
    }
    
    /**
     * Mencari slot pertama yang tersedia untuk dokter dan tanggal tertentu
     */
    private function findFirstAvailableSlot($doctorId, $tanggalPeriksa)
    {
        // Dapatkan hari dari tanggal periksa
        $dayOfWeek = \Carbon\Carbon::parse($tanggalPeriksa)->format('l');
        
        // Konversi ke bahasa Indonesia
        $dayMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $hari = $dayMapping[$dayOfWeek] ?? $dayOfWeek;
    
        \Log::info('DEBUG: Mencari jadwal dokter', [
            'doctor_id' => $doctorId,
            'day_of_week' => $dayOfWeek,
            'hari_indonesia' => $hari
        ]);
    
        // Ambil jadwal dokter untuk hari tersebut
        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('hari', $hari)
            ->first();
    
        \Log::info('DEBUG: Hasil pencarian jadwal', [
            'schedule_found' => $schedule ? true : false,
            'schedule_data' => $schedule
        ]);
    
        if (!$schedule) {
            return null; // Dokter tidak praktik di hari tersebut
        }
    
        // Generate semua slot yang mungkin berdasarkan jadwal
        $allSlots = $this->generateTimeSlots(
            $schedule->jam_mulai,
            $schedule->jam_selesai,
            $schedule->waktu_periksa,
            $schedule->waktu_jeda ?? 0
        );
    
        \Log::info('DEBUG: Generated slots', [
            'total_slots' => count($allSlots),
            'slots' => $allSlots
        ]);
    
        // Ambil slot yang sudah terbooked
        $bookedSlots = Queue::where('doctor_id', $doctorId)
            ->where('tgl_periksa', $tanggalPeriksa)
            ->where('is_booked', true)
            ->pluck('start_time')
            ->toArray();
    
        \Log::info('DEBUG: Booked slots', [
            'booked_slots' => $bookedSlots
        ]);
    
        // Cari slot pertama yang belum terbooked
        foreach ($allSlots as $slot) {
            if (!in_array($slot['start_time'], $bookedSlots)) {
                \Log::info('DEBUG: Found available slot', $slot);
                return $slot;
            }
        }
    
        \Log::info('DEBUG: No available slots found');
        return null; // Semua slot sudah terbooked
    }
    
    /**
     * Generate time slots berdasarkan jadwal dokter
     */
    private function generateTimeSlots($jamMulai, $jamSelesai, $waktuPeriksa, $waktuJeda = 0)
    {
        $slots = [];
        
        try {
            $currentTime = \Carbon\Carbon::createFromFormat('H:i:s', $jamMulai);
            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $jamSelesai);
            
            \Log::info('DEBUG: Generating time slots', [
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'waktu_periksa' => $waktuPeriksa,
                'waktu_jeda' => $waktuJeda
            ]);
    
            while ($currentTime->lt($endTime)) {
                $slotEnd = $currentTime->copy()->addMinutes($waktuPeriksa);
                
                // Pastikan slot tidak melewati jam selesai
                if ($slotEnd->lte($endTime)) {
                    $slots[] = [
                        'start_time' => $currentTime->format('H:i:s'),
                        'end_time' => $slotEnd->format('H:i:s')
                    ];
                }
    
                // Pindah ke slot berikutnya (waktu periksa + waktu jeda)
                $currentTime->addMinutes($waktuPeriksa + $waktuJeda);
            }
        } catch (\Exception $e) {
            \Log::error('DEBUG: Error generating time slots', [
                'error' => $e->getMessage(),
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'waktu_periksa' => $waktuPeriksa,
                'waktu_jeda' => $waktuJeda
            ]);
        }
    
        return $slots;
    }
    
    /**
     * Method untuk test/debug - bisa dipanggil dari route terpisah
     */
    public function debugSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $tanggalPeriksa = $request->tgl_periksa;
        
        $debugInfo = $this->getDebugInfo($doctorId, $tanggalPeriksa);
        $availableSlot = $this->findFirstAvailableSlot($doctorId, $tanggalPeriksa);
        
        return response()->json([
            'debug_info' => $debugInfo,
            'available_slot' => $availableSlot,
            'has_available_slot' => $availableSlot ? true : false
        ]);
    }

    // public function show_history()
    // {
    //     // $user = auth()->user();
    //     // $role = $user->role;

    //     // if ($role === 'admin' || $role === 'dokter') {

    //     // } else {
    //     //     $queueHistories = QueueHistory::where('user_id', $user->id)->get();
    //     // }

    //     $queueHistories = QueueHistory::all();

    //     return response()->json([
    //         'data' => $queueHistories,
    //     ], 200);
    // }
    public function show_history(Request $request)
{
    $request->validate([
        'queue_id' => 'required|exists:queues,id',
    ]);

    $user = auth()->user();

    $queue = Queue::where('id', $request->queue_id)
        ->where('user_id', $user->id)
        ->where('status', 'selesai')
        ->with(['medicalRecord.transaction', 'medicalRecord.medicines']) // Tambah eager load medicines
        ->first();

    if (!$queue || !$queue->medicalRecord) {
        return response()->json([
            'success' => false,
            'message' => 'Medical record tidak ditemukan atau antrian belum selesai.',
        ], 404);
    }

    // Ambil daftar nama obat dari relasi medicines
    $medicines = $queue->medicalRecord->medicines->map(function ($medicine) {
        return [
            'id' => $medicine->id,
            'name' => $medicine->name,
            'price' => $medicine->price,
        ];
    });

    // Prepare response data
    $responseData = [
        'medical_record' => $queue->medicalRecord,
        'jenis_pembayaran' => $queue->medicalRecord->transaction->jenis_pembayaran ?? null,
        'total' => $queue->medicalRecord->transaction->total ?? null,
        'medicines' => $medicines, // Tambahkan daftar obat di sini
    ];

    return response()->json([
        'success' => true,
        'data' => $responseData
    ]);
}



    public function show_dokter()
    {
        $doctors = DB::table('doctors')
            ->select('id', 'user_id', 'specialization_id', 'kode_dokter', 'nama_depan', 'nama_belakang', 'email', 'no_hp', 'tgl_lahir', 'pengalaman', 'jenis_kelamin', 'golongan_darah')
            ->get();

        return response()->json([
            'data' => $doctors,
        ], 200);
    }

    public function show_poli()
    {
        $specializations = DB::table('specializations')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'data' => $specializations,
        ], 200);
    }

    public function show_dokter_by_poli($id)
    {
        $doctors = DB::table('doctors')
            ->where('specialization_id', $id)
            ->select('id', 'user_id', 'specialization_id', 'kode_dokter', 'nama_depan', 'nama_belakang', 'email', 'no_hp', 'tgl_lahir', 'pengalaman', 'jenis_kelamin', 'golongan_darah')
            ->get();

        return response()->json([
            'data' => $doctors,
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
