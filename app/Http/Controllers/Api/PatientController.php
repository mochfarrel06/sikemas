<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = DB::table('patients')
            ->select('id', 'kode_pasien', 'nama_depan', 'nama_belakang', 'email', 'no_hp', 'tgl_lahir', 'jenis_kelamin', 'alamat', 'negara', 'provinsi', 'kota', 'kodepos')
            ->get();

        return response()->json([
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
        // $patient = Patient::findOrFail($id);
        $patient = DB::selectOne("SELECT id, kode_pasien, nama_depan, nama_belakang, email, no_hp, tgl_lahir, jenis_kelamin, alamat, negara, provinsi, kota, kodepos FROM patients WHERE id = ? LIMIT 1", [$id]);
        if (!$patient) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($patient, 200);
    }

    public function update(Request $request)
    {
        try {
            $user = $request->user(); 
            $patient = $user->patient; 
    
            if (!$patient) {
                return response()->json(['error' => 'Data pasien tidak ditemukan.'], 404);
            }
    
            $request->validate([
                'nama_depan' => 'nullable|string|max:100',
                'nama_belakang' => 'nullable|string|max:100',
                'no_hp' => 'nullable|string|max:20',
                'tgl_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|string|in:L,P',
                'alamat' => 'nullable|string|max:255',
                'negara' => 'nullable|string|max:100',
                'provinsi' => 'nullable|string|max:100',
                'kota' => 'nullable|string|max:100',
                'kodepos' => 'nullable|string|max:20',
                'no_nik' => 'nullable|string|max:50|unique:users,no_nik,' . $user->id,
                'no_bpjs' => 'nullable|string|max:50|unique:users,no_bpjs,' . $user->id,
            ]);
    
            $data = $request->only([
                'nama_depan',
                'nama_belakang',
                'no_hp',
                'tgl_lahir',
                'jenis_kelamin',
                'alamat',
                'negara',
                'provinsi',
                'kota',
                'kodepos',
                'no_nik',
                'no_bpjs',
            ]);
    
            $user->update($data);
            $patient->update($data); 
            return response()->json([
                'message' => 'Data pengguna & pasien berhasil diperbarui.',
                'user' => $user,
                'patient' => $patient,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);

            // Cari dan hapus user berdasarkan email pasien
            $user = User::where('email', $patient->email)->first();
            if ($user) {
                $user->delete();
            }

            $patient->delete();

            return response()->json(['message' => 'Data pasien berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
