<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())->count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->get();

        return view('doctor.dashboard', compact('jumlahAntrean', 'antreanHariIni'));
    }
}
