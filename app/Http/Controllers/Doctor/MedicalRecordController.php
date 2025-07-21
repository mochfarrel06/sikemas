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
use Carbon\Carbon;

class MedicalRecordController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        // Jika user adalah admin, ambil semua data medical record yang dikelompokkan per pasien
        $medicalRecords = MedicalRecord::with(['queue.patient', 'medicines'])
            ->get()
            ->groupBy('queue.patient.id')
            ->map(function ($records) {
                // Ambil record terbaru untuk ditampilkan di index
                $latestRecord = $records->sortByDesc('tgl_periksa')->first();
                $latestRecord->total_visits = $records->count();
                $latestRecord->first_visit = $records->sortBy('tgl_periksa')->first()->tgl_periksa;
                $latestRecord->last_visit = $records->sortByDesc('tgl_periksa')->first()->tgl_periksa;
                return $latestRecord;
            })
            ->values();
    } elseif ($user->role === 'farmasi') {
        $medicalRecords = MedicalRecord::with(['queue.patient', 'medicines'])
            ->get()
            ->groupBy('queue.patient.id')
            ->map(function ($records) {
                $latestRecord = $records->sortByDesc('tgl_periksa')->first();
                $latestRecord->total_visits = $records->count();
                $latestRecord->first_visit = $records->sortBy('tgl_periksa')->first()->tgl_periksa;
                $latestRecord->last_visit = $records->sortByDesc('tgl_periksa')->first()->tgl_periksa;
                return $latestRecord;
            })
            ->values();

        $hasNewMedicalRecordWithMedicines = MedicalRecord::whereHas('medicines')->exists();

        if ($hasNewMedicalRecordWithMedicines) {
            session()->flash('notif', 'Terdapat rekam medis baru yang perlu diproses farmasi.');
        }
    } else {
        // Jika bukan admin (misalnya dokter), ambil hanya yang sesuai dengan dokter
        $medicalRecords = MedicalRecord::whereHas('queue', function ($query) use ($user) {
            $query->where('doctor_id', $user->doctor->id);
        })
            ->with(['queue.patient', 'medicines'])
            ->get()
            ->groupBy('queue.patient.id')
            ->map(function ($records) {
                $latestRecord = $records->sortByDesc('tgl_periksa')->first();
                $latestRecord->total_visits = $records->count();
                $latestRecord->first_visit = $records->sortBy('tgl_periksa')->first()->tgl_periksa;
                $latestRecord->last_visit = $records->sortByDesc('tgl_periksa')->first()->tgl_periksa;
                return $latestRecord;
            })
            ->values();
    }

    return view('doctor.medical-record.index', compact('medicalRecords'));
}


    public function create()
{
    $user = auth()->user();
    $today = Carbon::today();

    if ($user->role === 'admin') {
        // Admin melihat antrean 'periksa' untuk hari ini
        $queues = Queue::where('status', 'periksa')
            ->whereDate('tgl_periksa', $today)
            ->get();
    } else {
        // Dokter hanya melihat antrean 'periksa' hari ini miliknya
        $queues = Queue::where('status', 'periksa')
            ->where('doctor_id', $user->doctor->id)
            ->whereDate('tgl_periksa', $today)
            ->get();
    }

    $medicines = Medicine::all();
    $diagnoses = MedicalRecord::select('diagnosis')
        ->distinct()
        ->pluck('diagnosis')
        ->filter()
        ->values();
    $catatanList = MedicalRecord::select('catatan_medis')
        ->whereNotNull('catatan_medis')
        ->distinct()
        ->pluck('catatan_medis')
        ->filter()
        ->values();
    
    return view('doctor.medical-record.create', compact('queues', 'medicines', 'diagnoses', 'catatanList'));
    
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
                'tindakan' => $request->tindakan,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'tekanan_darah' => $request->tekanan_darah,
            ]);
    
            if ($request->has('medicine_id')) {
                foreach ($request->medicine_id as $index => $medicineId) {
                    $medicalRecord->medicines()->attach($medicineId, [
                        'usage_instruction' => $request->usage_instruction[$index] ?? null,
                    ]);
                }
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
    

    public function generatePDF($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.pdf', compact('medicalRecord'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rekam_medis.pdf');
    }

   public function show(string $patientId)
{
    $user = auth()->user();
    
    // Ambil data pasien
    $patient = User::findOrFail($patientId);
    
    // Ambil semua medical records untuk pasien ini
    if ($user->role === 'admin' || $user->role === 'farmasi') {
        $medicalRecords = MedicalRecord::whereHas('queue', function ($query) use ($patientId) {
            $query->where('patient_id', $patientId);
        })
        ->with(['queue.patient', 'medicines'])
        ->orderBy('tgl_periksa', 'desc')
        ->get();
    } else {
        // Untuk dokter, hanya tampilkan record yang mereka tangani
        $medicalRecords = MedicalRecord::whereHas('queue', function ($query) use ($user, $patientId) {
            $query->where('doctor_id', $user->doctor->id)
                  ->where('patient_id', $patientId);
        })
        ->with(['queue.patient', 'medicines'])
        ->orderBy('tgl_periksa', 'desc')
        ->get();
    }
    
    return view('doctor.medical-record.show', compact('medicalRecords', 'patient'));
}

    public function generateNota($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.nota', compact('medicalRecord'))
            ->setPaper([0, 0, 500, 500], 'portrait');

        return $pdf->stream('nota.pdf');
    }
}
