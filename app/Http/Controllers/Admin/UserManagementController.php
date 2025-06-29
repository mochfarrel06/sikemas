<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserManagementStoreRequest;
use App\Http\Requests\UserManagement\UserManagementUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(){
        $users = User::all();

        return view('admin.user-management.index', compact('users'));
    }

    public function create(){
        return view('admin.user-management.create');
    }

    public function store(UserManagementStoreRequest $request)
    {
        try {
            $user = new User([
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            $user->save();

            session()->flash('success', 'Berhasil menambahkan data manajemen pengguna');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data manajemen pengguna: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit(string $id){
        $user = User::findOrFail($id);

        return view('admin.user-management.edit', compact('user'));
    }

    public function update(UserManagementUpdateRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
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
                    // Pastikan ada relasi antara User dan Doktor, misalnya $user->doktor
                    $doktor = $user->doctor; // Relasi harus sudah dibuat di model User
                    if ($doktor) {
                        $doktor->nama_depan = $request->nama_depan;
                        $doktor->nama_belakang = $request->nama_belakang;
                        $doktor->email = $request->email;
                        $doktor->save();
                    }
                }

                session()->flash('success', 'Berhasil melakukan perubahan data manajemen pengguna');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan data manajemen pengguna');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses updata manajemen pengguna: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->patient) {
            $user->patient->delete();
        }

            $user->delete();

            return redirect()->route('admin.user-management.index')
                ->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.user-management.index')
                ->with('error', 'Terdapat kesalahan');
        }
    }
}
