<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\MedicalRecordStoreRequest;
use App\Models\MedicalRecord;
use App\Models\Queue;
use App\Models\QueueHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::all();

        return view('doctor.medical-record.index', compact('medicalRecords'));
    }

    public function create()
    {
        $queues = Queue::where('status', 'periksa')->get();
        return view('doctor.medical-record.create', compact('queues'));
    }

    public function store(MedicalRecordStoreRequest $request)
    {
        try {
            $queue = Queue::findOrFail($request->queue_id);

            MedicalRecord::create([
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
            ]);

            $queue->update(['status' => 'selesai']);

            QueueHistory::create([
                'queue_id' => $queue->id,
                'user_id' => $queue->user_id,
                'doctor_id' => $queue->doctor_id,
                'patient_id' => $queue->patient_id,
                'tgl_periksa' => $queue->tgl_periksa,
                'start_time' => $queue->start_time,
                'end_time' => $queue->end_time,
                'keterangan' => $queue->keterangan,
                'status' => $queue->status,
                'is_booked' => $queue->is_booked,
            ]);

            session()->flash('success', 'Berhasil menambahkan data rekam medis');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function generatePDF($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.pdf', compact('medicalRecord'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rekam_medis.pdf');
    }

    public function show(string $id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        return view('doctor.medical-record.show', compact('medicalRecord'));
    }
}
