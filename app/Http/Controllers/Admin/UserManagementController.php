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

            $user->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data user']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
