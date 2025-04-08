<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahDokter = Doctor::count();
        $jumlahPasien = Patient::count();
        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())->count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.dashboard', compact('jumlahDokter', 'jumlahPasien', 'jumlahAntrean', 'antreanHariIni'));
    }
}
