<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::all();

        $hasNewMedicalRecordWithMedicines = \App\Models\MedicalRecord::whereHas('medicines')->exists();

        return view('admin.medicine.index', compact('medicines', 'hasNewMedicalRecordWithMedicines'));
    }

    public function create()
    {
        return view('admin.medicine.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|string',
        ], [
            'name.required' => 'Nama obat tidak boleh kosong.',
            'price.required' => 'Harga tidak boleh kosong.',
        ]);

        try {
            $medicines = new Medicine([
                'name' => $validated['name'],
                'price' => $validated['price']
            ]);

            $medicines->save();

            session()->flash('success', 'Berhasil menambahkan data obat');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data obat: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);

        return view('admin.medicine.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|string',
        ], [
            'name.required' => 'Nama obat tidak boleh kosong.',
            'price.required' => 'Harga tidak boleh kosong.',
        ]);

        try {
            $medicine = Medicine::findOrFail($id);

            $medicine->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            session()->flash('success', 'Berhasil memperbarui data obat');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses update obat: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $medicine = Medicine::findOrFail($id);

            $medicine->delete();

            return redirect()->route('admin.medicines.index')
                ->with('success', 'Data Obat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.medicines.index')
                ->with('error', 'Terdapat kesalahan.');
        }
    }
}
