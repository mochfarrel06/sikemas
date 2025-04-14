<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Queue;
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
}
