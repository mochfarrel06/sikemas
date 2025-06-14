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

    public function create($medical_record_id)
    {
        $medicalRecord = MedicalRecord::with('queue', 'medicines', 'patient')->findOrFail($medical_record_id);

        // Validasi jika status antrean belum selesai, redirect
        if ($medicalRecord->queue->status !== 'selesai') {
            return redirect()->route('transaction.index')->with('error', 'Pasien belum menyelesaikan pemeriksaan.');
        }

        return view('doctor.transaction.create', compact('medicalRecord'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'user_id' => 'nullable',
            'jenis_pembayaran' => 'required',
            'total' => 'required|numeric',
            'no_bpjs' => 'nullable|string|max:255',
        ]);

        $medicalRecord = MedicalRecord::with('queue.patient')->findOrFail($request->medical_record_id);
        $patient = $medicalRecord->queue->patient;

        // Simpan transaksi
        Transaction::create([
            'user_id' => $userId,
            'medical_record_id' => $medicalRecord->id,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'total' => $request->total,
        ]);

        // Update no_bpjs jika diisi ulang
        if ($request->no_bpjs) {
            // Update ke patients jika berubah
            if ($patient->no_bpjs !== $request->no_bpjs) {
                $patient->update(['no_bpjs' => $request->no_bpjs]);
            }

            // Update ke users jika berubah
            if ($patient->user && $patient->user->no_bpjs !== $request->no_bpjs) {
                $patient->user->update(['no_bpjs' => $request->no_bpjs]);
            }
        }

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
}
