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

        // Cek apakah sudah ada medical record untuk queue ini
        $existingMedicalRecord = MedicalRecord::where('queue_id', $queue->id)->first();

        if ($user->role === 'admin') {
            // Admin hanya bisa input/update data vital
            if ($existingMedicalRecord) {
                // Update data vital yang sudah ada
                $existingMedicalRecord->update([
                    'tinggi_badan' => $request->tinggi_badan,
                    'berat_badan' => $request->berat_badan,
                    'tekanan_darah' => $request->tekanan_darah,
                ]);

                session()->flash('success', 'Berhasil mengupdate data vital pasien');
                return redirect()->route('doctor.medical-record.index');
            } else {
                // Buat record baru dengan data vital saja
                $medicalRecord = MedicalRecord::create([
                    'user_id' => $queue->user_id,
                    'queue_id' => $queue->id,
                    'tgl_periksa' => now(),
                    'tinggi_badan' => $request->tinggi_badan,
                    'berat_badan' => $request->berat_badan,
                    'tekanan_darah' => $request->tekanan_darah,
                    // Field lain dibiarkan null untuk dilengkapi dokter
                    'diagnosis' => null,
                    'resep' => null,
                    'catatan_medis' => null,
                ]);

                // Update status queue menjadi 'dalam_pemeriksaan' (menunggu dokter)
                $queue->update([
                    'status' => 'dalam_pemeriksaan',
                    'medical_id' => $medicalRecord->id,
                ]);

                session()->flash('success', 'Berhasil menambahkan data vital pasien');
                return redirect()->route('doctor.medical-record.index');
            }
        }

        if ($user->role === 'doctor') {
            // Dokter bisa input/update semua data kecuali data vital (readonly)
            if ($existingMedicalRecord) {
                // Update data medis (tidak mengubah data vital)
                $existingMedicalRecord->update([
                    'diagnosis' => $request->diagnosis,
                    'resep' => $request->resep,
                    'catatan_medis' => $request->catatan_medis,
                    'tgl_periksa' => now(), // Update tanggal periksa
                ]);

                // Update medicines relationship
                if ($request->has('medicine_id')) {
                    $existingMedicalRecord->medicines()->sync($request->medicine_id);
                }

                // Update status queue menjadi selesai
                $queue->update([
                    'status' => 'selesai',
                ]);

                session()->flash('success', 'Berhasil melengkapi data rekam medis');
                return redirect()->route('doctor.medical-record.index');
            } else {
                // Jika belum ada record, buat baru (tanpa data vital)
                $medicalRecord = MedicalRecord::create([
                    'user_id' => $queue->user_id,
                    'queue_id' => $queue->id,
                    'tgl_periksa' => now(),
                    'diagnosis' => $request->diagnosis,
                    'resep' => $request->resep,
                    'catatan_medis' => $request->catatan_medis,
                    // Data vital dibiarkan null (harus diisi admin)
                    'tinggi_badan' => null,
                    'berat_badan' => null,
                    'tekanan_darah' => null,
                ]);

                // Attach medicines
                if ($request->has('medicine_id')) {
                    $medicalRecord->medicines()->attach($request->medicine_id);
                }

                // Update status queue
                $queue->update([
                    'status' => 'dalam_pemeriksaan', // Menunggu admin input data vital
                    'medical_id' => $medicalRecord->id,
                ]);

                session()->flash('success', 'Berhasil menambahkan data rekam medis');
                return redirect()->route('doctor.medical-record.index');
            }
        }

        // Fallback untuk role lain (jika ada)
        session()->flash('error', 'Akses tidak diizinkan untuk role Anda');
        return redirect()->route('doctor.medical-record.index');

    } catch (\Exception $e) {
        session()->flash('error', 'Terdapat kesalahan pada proses data: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}
public function getExistingData($queueId)
{
    try {
        $medicalRecord = MedicalRecord::with('medicines')
            ->where('queue_id', $queueId)
            ->first();

        if ($medicalRecord) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tinggi_badan' => $medicalRecord->tinggi_badan,
                    'berat_badan' => $medicalRecord->berat_badan,
                    'tekanan_darah' => $medicalRecord->tekanan_darah,
                    'diagnosis' => $medicalRecord->diagnosis,
                    'resep' => $medicalRecord->resep,
                    'catatan_medis' => $medicalRecord->catatan_medis,
                    'medicines' => $medicalRecord->medicines,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
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
