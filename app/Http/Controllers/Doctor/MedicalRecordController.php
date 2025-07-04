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

            $medicalRecord = MedicalRecord::create([
                'user_id' => $queue->user_id,
                // 'medicine_id' => $request->medicine_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,

                'gula_darah_acak' => $request->gula_darah_acak,
                'gula_darah_puasa' => $request->gula_darah_puasa,
                'gula_darah_2jm_pp' => $request->gula_darah_2jm_pp,
                'analisa_lemak' => $request->analisa_lemak,
                'cholesterol' => $request->cholesterol,
                'trigliserida' => $request->trigliserida,
                'hdl' => $request->hdl,
                'ldl' => $request->ldl,

                'asam_urat' => $request->asam_urat ?? null,
                'bun' => $request->bun ?? null,
                'creatinin' => $request->creatinin ?? null,
                'sgot' => $request->sgot ?? null,
                'sgpt' => $request->sgpt ?? null,
                'warna' => $request->warna ?? null,
                'ph' => $request->ph ?? null,
                'berat_jenis' => $request->berat_jenis ?? null,
                'reduksi' => $request->reduksi ?? null,
                'protein' => $request->protein ?? null,
                'bilirubin' => $request->bilirubin ?? null,
                'urobilinogen' => $request->urobilinogen ?? null,
                'nitrit' => $request->nitrit ?? null,
                'keton' => $request->keton ?? null,
                'sedimen_lekosit' => $request->sedimen_lekosit ?? null,
                'sedimen_eritrosit' => $request->sedimen_eritrosit ?? null,
                'sedimen_epitel' => $request->sedimen_epitel ?? null,
                'sedimen_kristal' => $request->sedimen_kristal ?? null,
                'sedimen_bakteri' => $request->sedimen_bakteri ?? null,
                'hemoglobin' => $request->hemoglobin ?? null,
                'leukosit' => $request->leukosit ?? null,
                'erytrosit' => $request->erytrosit ?? null,
                'trombosit' => $request->trombosit ?? null,
                'pcv' => $request->pcv ?? null,
                'dif' => $request->dif ?? null,
                'bleeding_time' => $request->bleeding_time ?? null,
                'clotting_time' => $request->clotting_time ?? null,
                'salmonella_o' => $request->salmonella_o ?? null,
                'salmonella_h' => $request->salmonella_h ?? null,
                'salmonella_p_a' => $request->salmonella_p_a ?? null,
                'salmonella_p_b' => $request->salmonella_p_b ?? null,
                'hbsag' => $request->hbsag ?? null,
                'vdrl' => $request->vdrl ?? null,
                'plano_test' => $request->plano_test ?? null,
            ]);

            if ($request->has('medicine_id')) {
                $medicalRecord->medicines()->attach($request->medicine_id);
            }


            $queue->update([
                'status' => 'selesai',
                'medical_id' => $medicalRecord->id,
            ]);

            // QueueHistory::create([
            //     'queue_id' => $queue->id,
            //     'user_id' => $queue->user_id,
            //     'doctor_id' => $queue->doctor_id,
            //     'patient_id' => $queue->patient_id,
            //     'tgl_periksa' => $queue->tgl_periksa,
            //     'start_time' => $queue->start_time,
            //     'end_time' => $queue->end_time,
            //     'keterangan' => $queue->keterangan,
            //     'status' => $queue->status,
            //     'is_booked' => $queue->is_booked,
            // ]);

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
