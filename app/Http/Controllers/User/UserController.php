<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function indexDokter()
    {
        $doctors = Doctor::all();
        return view('user.dokter', compact('doctors'));
    }

    public function indexTentangKami()
    {
        return view('user.tentang-kami');
    }
}
