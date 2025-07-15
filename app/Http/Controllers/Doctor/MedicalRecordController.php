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
        } elseif ($user->role === 'farmasi') {
            $medicalRecords = MedicalRecord::with(['queue.patient', 'medicines'])->get();

            $hasNewMedicalRecordWithMedicines = MedicalRecord::whereHas('medicines')->exists();

            if ($hasNewMedicalRecordWithMedicines) {
                session()->flash('notif', 'Terdapat rekam medis baru yang perlu diproses farmasi.');
            }
        }else {
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

            $medicalRecord = MedicalRecord::create([
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan, // Tambahkan ini
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'tekanan_darah' => $request->tekanan_darah,
            ]);


            if ($request->has('medicine_id')) {
                $medicalRecord->medicines()->attach($request->medicine_id);
            }


            $queue->update([
                'status' => 'selesai',
                'medical_id' => $medicalRecord->id,
            ]);


            session()->flash('success', 'Berhasil menambahkan data rekam medis');
            // return redirect()->route('transaction.transaction.create', $medicalRecord->id);
            return redirect()->route('doctor.medical-record.index');
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
