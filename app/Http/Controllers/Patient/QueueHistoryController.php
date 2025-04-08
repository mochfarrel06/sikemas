<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
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
            $queueHistories = QueueHistory::all();
        } else {
            $queueHistories = QueueHistory::where('user_id', $user->id)->get();
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
}
