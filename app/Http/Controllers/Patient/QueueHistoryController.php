<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Queue;
use App\Models\QueueHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QueueHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queueHistories = Queue::with('doctor')
                ->where('status', '!=', 'booking')
                ->where('status', '!=', 'periksa')
                ->get();
        } else {
            $queueHistories = Queue::with('doctor')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'booking')
            ->where('status', '!=', 'periksa')
            ->get();
        }

        return view('patient.queue-history.index', compact('queueHistories'));
    }

    public function exportPdf()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $queueHistories = QueueHistory::all();
        } else {
            $queueHistories = QueueHistory::where('user_id', $user->id)->get();
        }

        $pdf = Pdf::loadView('patient.queue-history.pdf', compact('queueHistories'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('riwaayat_antrean.pdf');
    }

    public function show(string $id)
    {
        $queue = Queue::findOrFail($id);

        return view('patient.queue-history.show', compact('queue'));
    }

    public function generatePDF($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.pdf', compact('medicalRecord'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rekam_medis.pdf');
    }
}
