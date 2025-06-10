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
        $doctorId = auth()->user()->doctor->id;

        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())
            ->where('doctor_id', $doctorId)
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->where('doctor_id', $doctorId)
            ->orderBy('start_time', 'asc')
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->get();

        return view('doctor.dashboard', compact('jumlahAntrean', 'antreanHariIni'));
    }
}
