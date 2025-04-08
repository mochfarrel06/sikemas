<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return view('admin.patient.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(PatientStoreRequest $request)
    {
        try {
            $patient = new Patient([
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

            User::create([
                'name' => $request->nama_depan . ' ' . $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien'
            ]);

            session()->flash('success', 'Berhasil menambahkan data pasien');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data pasien: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);

        return view('admin.patient.show', compact('patient'));
    }

    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);

        return view('admin.patient.edit', compact('patient'));
    }

    public function update(PatientUpdateRequest $request, string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patients = $request->except('password');
            $user = User::findOrFail($patient->user_id);
            $userData = $request->only(['nama_depan', 'nama_belakang', 'email', 'no_hp', 'tgl_lahir', 'jenis_kelamin', 'alamat', 'negara', 'provinsi', 'kota', 'kodepos']);

            // Handle password update
            if ($request->filled('password')) {
                $patients['password'] = bcrypt($request->password);
            }

            $patient->fill($patients);

            if ($patient->isDirty()) {
                $patient->save();
                $user->update($userData);

                session()->flash('success', 'Berhasil melakukan perubahan pada data pasien');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan pada data pasien');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses update data pasien: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data pasien']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
