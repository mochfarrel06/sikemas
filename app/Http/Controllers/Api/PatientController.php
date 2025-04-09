<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return response()->json([
            'message' => 'Data pasien di tampilkan',
            'data' => $patients,
        ], 200);
    }
}
