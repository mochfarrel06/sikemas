<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Models\Patient;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        if ($request->user()->role === 'admin') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } else if ($request->user()->role === 'dokter') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::DOCTOR);
        } else if ($request->user()->role === 'pasien') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::PATIENT);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', 'Berhasil keluar aplikasi');
        return redirect('/login');
    }

    public function indexRegister(){
        return view('auth.register');
    }

    public function storeRegister(PatientStoreRequest $request)
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
            ]);

            $patient->save();

            session()->flash('success', 'Berhasil membuat akun pasien');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses pembuatan akun: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function indexForgot(){
        return view('auth.forgotPassword');
    }
}
