<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        $specializations = Specialization::all();

        // return view('profile.index')
        //     ->with('user' , $user)
        //     ->with('doctor', $role == 'dokter' ? $user->doctor : null)
        //     ->with('specializations', $specializations);

        return view('profile.index', compact('user', 'specializations'));
    }
}
