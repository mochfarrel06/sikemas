<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        $specializations = Specialization::all();

        return view('profile.index', compact('user', 'specializations', 'role'));
    }

    public function update(Request $request)
    {
        try {
            // dd($request->all());
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            $users = $request->except('password');

            // Handle password update
            if ($request->filled('password')) {
                $users['password'] = bcrypt($request->password);
            }

            $user->fill($users);

            if ($user->isDirty()) {
                $user->save();

                // Tambahkan ini untuk update nama di tabel doktors
                if ($user->role === 'dokter') {
                    $doktor = $user->doctor; // Relasi harus sudah dibuat di model User
                    if ($doktor) {
                        $doktor->nama_depan = $request->nama_depan;
                        $doktor->nama_belakang = $request->nama_belakang;
                        $doktor->email = $request->email;
                        $doktor->no_hp = $request->no_hp;
                        $doktor->tgl_lahir = $request->tgl_lahir;
                        $doktor->jenis_kelamin = $request->jenis_kelamin;
                        $doktor->alamat = $request->alamat;
                        $doktor->negara = $request->negara;
                        $doktor->provinsi = $request->provinsi;
                        $doktor->kota = $request->kota;
                        $doktor->kodepos = $request->kodepos;
                        $doktor->save();
                    }
                }

                session()->flash('success', 'Berhasil melakukan perubahan data profil');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan data profil');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses updata profil: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
