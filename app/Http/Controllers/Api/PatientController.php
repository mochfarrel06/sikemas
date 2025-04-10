<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_depan' => 'required',
                'nama_belakang' => 'required',
                'email' => 'required|email|unique:patients,email',
                'password' => 'required',
                'no_hp' => 'required',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required',
                'alamat' => 'required',
                'negara' => 'required',
                'provinsi' => 'required',
                'kota' => 'required',
                'kodepos' => 'required',
            ]);

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

            $patient = Patient::create([
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


            return response()->json([
                'success' => true,
                'message' => 'Akun pasien berhasil dibuat.',
                'data' => [
                    'user' => $user,
                    'patient' => $patient
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $data = $request->except('password');

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $patient->update($data);

            return response()->json(['success' => true, 'data' => $patient]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response()->json(['success' => true, 'message' => 'Data pasien berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
