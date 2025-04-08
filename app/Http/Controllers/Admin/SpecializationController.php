<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\SpecializationStoreRequest;
use App\Http\Requests\Doctor\SpecializationUpdateRequest;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specialization::all();

        return view('admin.specialization.index', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specialization.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecializationStoreRequest $request)
    {
        try {
            $specialization = new Specialization([
                'name' => $request->name,
            ]);

            $specialization->save();

            session()->flash('success', 'Berhasil menambahkan data spesialisasi');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data spesialisasi: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specialization = Specialization::findOrFail($id);

        return view('admin.specialization.show', compact('specialization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specialization = Specialization::findOrFail($id);

        return view('admin.specialization.edit', compact('specialization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecializationUpdateRequest $request, string $id)
    {
        try {
            $specialization = Specialization::findOrFail($id);

            $specializations = $request->all();

            $specialization->fill($specializations);

            if ($specialization->isDirty()) {
                $specialization->save();

                session()->flash('success', 'Berhasil melakukan perubahan spesialisasi');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan spesialisasi');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses spesialisasi: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $specialization = Specialization::findOrFail($id);

            $specialization->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data spesialisasi']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
