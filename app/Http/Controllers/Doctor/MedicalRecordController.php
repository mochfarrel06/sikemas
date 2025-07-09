<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\MedicalRecordStoreRequest;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Queue;
use App\Models\QueueHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Jika user adalah admin, ambil semua data medical record
            $medicalRecords = MedicalRecord::with(['queue.patient', 'medicines'])->get();
        } else {
            // Jika bukan admin (misalnya dokter), ambil hanya yang sesuai dengan dokter
            $medicalRecords = MedicalRecord::whereHas('queue', function ($query) use ($user) {
                $query->where('doctor_id', $user->doctor->id);
            })->with(['queue.patient', 'medicines'])->get();
        }

        return view('doctor.medical-record.index', compact('medicalRecords'));
    }


    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            // Admin bisa melihat semua antrean yang statusnya 'periksa'
            $queues = Queue::where('status', 'periksa')->get();
        } else {
            // Dokter hanya bisa melihat antrean yang sesuai dengan dirinya
            $queues = Queue::where('status', 'periksa')
                ->where('doctor_id', $user->doctor->id)
                ->get();
        }
        $medicines = Medicine::all();
        $diagnoses = MedicalRecord::select('diagnosis')
            ->distinct()
            ->pluck('diagnosis')
            ->filter() // Buang null/empty
            ->values();
        return view('doctor.medical-record.create', compact('queues', 'medicines', 'diagnoses'));
    }

    public function store(MedicalRecordStoreRequest $request)
    {
        try {
            $queue = Queue::findOrFail($request->queue_id);
            $user = auth()->user();

            $medicalRecordData = [
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
            ];

            // Jika user adalah admin, tambahkan data vital signs
            if ($user->role === 'admin') {
                $medicalRecordData['tinggi_badan'] = $request->tinggi_badan;
                $medicalRecordData['berat_badan'] = $request->berat_badan;
                $medicalRecordData['tekanan_darah'] = $request->tekanan_darah;
            }

            $medicalRecord = MedicalRecord::create($medicalRecordData);

            if ($request->has('medicine_id')) {
                $medicalRecord->medicines()->attach($request->medicine_id);
            }

            $queue->update([
                'status' => 'selesai',
                'medical_id' => $medicalRecord->id,
            ]);

            session()->flash('success', 'Berhasil menambahkan data rekam medis');
            return redirect()->route('doctor.medical-record.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function edit($id)
    {
        $medicalRecord = MedicalRecord::with(['queue.patient', 'medicines'])->findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'admin') {
            $queues = Queue::where('status', 'selesai')->get();
        } else {
            $queues = Queue::where('status', 'selesai')
                ->where('doctor_id', $user->doctor->id)
                ->get();
        }

        $medicines = Medicine::all();
        $diagnoses = MedicalRecord::select('diagnosis')
            ->distinct()
            ->pluck('diagnosis')
            ->filter()
            ->values();

        return view('doctor.medical-record.edit', compact('medicalRecord', 'queues', 'medicines', 'diagnoses'));
    }

    public function update(MedicalRecordStoreRequest $request, $id)
    {
        try {
            $medicalRecord = MedicalRecord::findOrFail($id);
            $user = auth()->user();

            $updateData = [
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
            ];

            // Jika user adalah admin, update data vital signs
            if ($user->role === 'admin') {
                $updateData['tinggi_badan'] = $request->tinggi_badan;
                $updateData['berat_badan'] = $request->berat_badan;
                $updateData['tekanan_darah'] = $request->tekanan_darah;
            }

            $medicalRecord->update($updateData);

            if ($request->has('medicine_id')) {
                $medicalRecord->medicines()->sync($request->medicine_id);
            }

            session()->flash('success', 'Berhasil memperbarui data rekam medis');
            return redirect()->route('doctor.medical-record.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses update: ' . $e->getMessage());
            return back()->withInput();
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
        $medicalRecord = MedicalRecord::with('medicines')->findOrFail($id);
        return view('doctor.medical-record.show', compact('medicalRecord'));
    }

    public function generateNota($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.nota', compact('medicalRecord'))
            ->setPaper([0, 0, 500, 500], 'portrait');

        return $pdf->stream('nota.pdf');
    }
}
