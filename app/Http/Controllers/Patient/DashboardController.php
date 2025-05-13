<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->get();

        return view('patient.dashboard', compact('jumlahAntrean', 'antreanHariIni'));
    }
}
