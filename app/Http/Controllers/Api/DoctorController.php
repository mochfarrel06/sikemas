<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();

        return response()->json([
            'message' => 'Data dokter di tampilkan',
            'data' => $doctors,
        ], 200);
    }

    public function store(Request $request)
    {
        // Lakukan validasi data dokter
        $validatedData = $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email|unique:users,email',
            'no_hp' => 'required|string|max:15',
            'tgl_lahir' => 'required|date',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|string|max:10',
            'golongan_darah' => 'required|string|max:3',
            'foto_dokter' => 'nullable|string',
            'alamat' => 'required|string',
            'negara' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kodepos' => 'required|string|max:10',
        ]);

        // Simpan data dokter ke tabel doctors
        $doctor = Doctor::create($validatedData);

        // Simpan data ke tabel users untuk melakukan login
        User::create([
            'name' => $doctor->nama_depan . ' ' . $doctor->nama_belakang,
            'email' => $doctor->email,
            'password' => Hash::make('password123'),
            'role' => 'dokter'
        ]);

        return response()->json([
            'message' => "Data dokter berhasil di tambahkan",
            'doctor' => $doctor,
        ], 201);
    }

    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return response()->json([
            'message' => 'Menampilkan detail dokter',
            'data' => $doctor
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_depan' => 'required|string',
            'nama_belakang' => 'required|string',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'no_hp' => 'required|string',
            'spesialisasi' => 'required|string',
            'pengalaman' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'golongan_darah' => 'required|string',
            'foto_dokter' => 'nullable|string',
            'alamat' => 'required|string',
            'negara' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kodepos' => 'required|string',
        ]);

        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            return response()->json([
                'message' => 'Data dokter tidak di temukan'
            ], 404);
        }

        $doctor->update($request->all());

        return response()->json([
            'message' => 'Data dokter berhasil di perbarui',
            'data' => $doctor,
        ], 200);
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            return response()->json([
                'message' => 'Data dokter tidak ditemukan'
            ], 404);
        }

        $doctor->delete();

        return response()->json([
            'message' => 'Data dokter berhasil di hapus',
        ], 200);
    }
}
