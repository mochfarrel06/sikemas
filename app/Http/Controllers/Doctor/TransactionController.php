<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        return view('doctor.transaction.index', compact('transactions'));
    }

    // public function create($medical_record_id)
    // {
    //     $medicalRecord = MedicalRecord::with('queue', 'medicines', 'patient')->findOrFail($medical_record_id);

    //     // Validasi jika status antrean belum selesai, redirect
    //     if ($medicalRecord->queue->status !== 'selesai') {
    //         return redirect()->route('transaction.index')->with('error', 'Pasien belum menyelesaikan pemeriksaan.');
    //     }

    //     return view('doctor.transaction.create', compact('medicalRecord'));
    // }

    public function create() {
        // $medicalRecords = MedicalRecord::all();
        // Ambil ID medical record yang sudah ada transaksi-nya
    $usedMedicalRecordIds = Transaction::pluck('medical_record_id')->toArray();

    // Ambil hanya medical record yang belum digunakan
    $medicalRecords = MedicalRecord::whereNotIn('id', $usedMedicalRecordIds)
        ->with(['queue.patient', 'medicines']) // Optional jika kamu perlu
        ->get();

        return view('doctor.transaction.create', compact('medicalRecords'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'user_id' => 'nullable',
            'medical_record_id' => 'required',
            'jenis_pembayaran' => 'required',
            'total' => 'required|numeric',
            // 'no_bpjs' => 'nullable|string|max:255',
        ]);

         Transaction::create([
            'user_id' => $userId,
            'medical_record_id' => $request->medical_record_id,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'total' => $request->total,
        ]);

        // $medicalRecord = MedicalRecord::with('queue.patient')->findOrFail($request->medical_record_id);
        // $patient = $medicalRecord->queue->patient;

        // // Simpan transaksi
        // Transaction::create([
        //     'user_id' => $userId,
        //     'medical_record_id' => $medicalRecord->id,
        //     'jenis_pembayaran' => $request->jenis_pembayaran,
        //     'total' => $request->total,
        // ]);

        // // Update no_bpjs jika diisi ulang
        // if ($request->no_bpjs) {
        //     // Update ke patients jika berubah
        //     if ($patient->no_bpjs !== $request->no_bpjs) {
        //         $patient->update(['no_bpjs' => $request->no_bpjs]);
        //     }

        //     // Update ke users jika berubah
        //     if ($patient->user && $patient->user->no_bpjs !== $request->no_bpjs) {
        //         $patient->user->update(['no_bpjs' => $request->no_bpjs]);
        //     }
        // }

        session()->flash('success', 'Berhasil menambahkan data transaksi');
        return response()->json(['success' => true], 200);
    }

    public function generateNota($id)
    {
        $transaction = Transaction::findOrFail($id);

        $pdf = Pdf::loadView('doctor.transaction.pdf', compact('transaction'))
            ->setPaper([0, 0, 500, 500], 'portrait');

        return $pdf->stream('nota.pdf');
    }

    public function getMedicines($id)
{
    $medicalRecord = MedicalRecord::with('medicines')->findOrFail($id);

    $medicines = $medicalRecord->medicines->map(function ($medicine) {
        return [
            'name' => $medicine->name,
            'price' => $medicine->price
        ];
    });

    $total = $medicalRecord->medicines->sum('price');

    return response()->json([
        'medicines' => $medicines,
        'total' => $total
    ]);
}
}
