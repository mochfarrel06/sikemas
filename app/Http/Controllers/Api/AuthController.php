<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        if ($user->role !== 'pasien') {
            return response()->json([
                'message' => 'Hanya pasien yang dapat mengakses aplikasi ini.',
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Berhasil masuk aplikasi',
            'user' => [
                'id' => $user->id,
                'nama_depan' => $user->nama_depan,
                'nama_belakang' => $user->nama_belakang,
                'email' => $user->email,
                'role' => $user->role,
                'foto' => $user->foto,
                'no_hp' => $user->no_hp,
                'tgl_lahir' => $user->tgl_lahir,
                'jenis_kelamin' => $user->jenis_kelamin,
                'alamat' => $user->alamat,
                'negara' => $user->negara,
                'provinsi' => $user->provinsi,
                'kota' => $user->kota,
                'kodepos' => $user->kodepos,
                'no_nik' => $user->no_nik,
                'no_bpjs' => $user->no_bpjs,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Anda telah logout.',
        ]);
    }

    public function register(Request $request)
    {
        try {

            $user = User::create([
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
                'no_hp' => $request->no_hp,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'negara' => $request->negara,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kodepos' => $request->kodepos,
                'no_nik' => $request->no_nik,
                'no_bpjs' => $request->no_bpjs,
            ]);

            $patient = new Patient([
                'user_id' => $user->id,
                'kode_pasien' => Patient::generateKodePasien(),
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'negara' => $request->negara,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kodepos' => $request->kodepos,
                // 'no_nik' => $request->no_nik,
                // 'no_bpjs' => $request->no_bpjs,
            ]);

            $patient->save();

            return response()->json([
                'message' => 'Akun pasien berhasil dibuat',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
