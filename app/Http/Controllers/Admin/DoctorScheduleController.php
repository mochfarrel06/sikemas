<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorScheduleStoreRequest;
use App\Http\Requests\Doctor\DoctorScheduleUpdateRequest;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('doctor_schedules')
                    ->groupBy('doctor_id');
            })
            ->get();
        return view('admin.doctorSchedule.index', compact('schedules'));
    }

    public function create()
    {
        $scheduledDoctorIds = DoctorSchedule::pluck('doctor_id')->toArray();
        $doctors = Doctor::whereNotIn('id', $scheduledDoctorIds)->get();

        return view('admin.doctorSchedule.create', compact('doctors'));
    }


    public function store(DoctorScheduleStoreRequest $request)
    {
        try {
            $doctorId = $request->doctor_id;

            foreach ($request->hari as $index => $hari) {
                $jamMulai = $request->jam_mulai[$hari] ?? null;
                $jamSelesai = $request->jam_selesai[$hari] ?? null;

                if (!$jamMulai || !$jamSelesai) {
                    continue;
                }

                // Periksa apakah jadwal dengan kombinasi ini sudah ada
                $existingSchedule = DoctorSchedule::where('doctor_id', $doctorId)
                    ->where('hari', $hari)
                    ->where('jam_mulai', $jamMulai)
                    ->where('jam_selesai', $jamSelesai)
                    ->first();

                if ($existingSchedule) {
                    continue;
                }

                // Buat jadwal baru
                DoctorSchedule::create([
                    'doctor_id' => $doctorId,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'waktu_periksa' => $request->waktu_periksa,
                    'waktu_jeda' => $request->waktu_jeda,
                ]);
            }

            return redirect()
                ->route('admin.doctor-schedules.index')
                ->with('success', 'Data jadwal dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($doctorId)
    {
        // Ambil data dokter
        $doctor = Doctor::findOrFail($doctorId);

        // Ambil jadwal dokter berdasarkan doctor_id
        $schedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->get()
            ->groupBy('hari');

        $firstSchedule = $schedules->first() ? $schedules->first()->first() : null; // Cek jika ada jadwal pertama

        // Siapkan default data hari (Senin-Minggu)
        $defaultDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $formattedSchedules = [];

        foreach ($defaultDays as $day) {
            if (isset($schedules[$day])) {
                $schedule = $schedules[$day]->first();
                $formattedSchedules[$day] = [
                    'jam_mulai' => $schedule->jam_mulai ? \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') : null,
                    'jam_selesai' => $schedule->jam_selesai ? \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') : null,
                ];
            } else {
                $formattedSchedules[$day] = [
                    'jam_mulai' => null,
                    'jam_selesai' => null,
                ];
            }
        }

        return view('admin.doctorSchedule.edit', compact('doctor', 'formattedSchedules', 'firstSchedule'));
    }

    public function update(DoctorScheduleUpdateRequest $request, string $doctorId)
    {
        try {
            foreach ($request->hari as $hari) {
                $jamMulai = $request->jam_mulai[$hari] ?? null;
                $jamSelesai = $request->jam_selesai[$hari] ?? null;

                if (!$jamMulai || !$jamSelesai) {
                    continue;
                }

                $schedule = DoctorSchedule::where('doctor_id', $doctorId)
                    ->where('hari', $hari)
                    ->first();

                if ($schedule) {
                    $schedule->update([
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'waktu_periksa' => $request->waktu_periksa,
                        'waktu_jeda' => $request->waktu_jeda,
                    ]);
                } else {
                    DoctorSchedule::create([
                        'doctor_id' => $doctorId,
                        'hari' => $hari,
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'waktu_periksa' => $request->waktu_periksa,
                        'waktu_jeda' => $request->waktu_jeda,
                    ]);
                }
            }

            $checkedHolidays = $request->hari ?? [];  // Hari-hari yang dicentang
            DoctorSchedule::where('doctor_id', $doctorId)
                ->whereNotIn('hari', $checkedHolidays)  // Hari yang tidak dicentang
                ->delete();  // Hapus jadwal untuk hari tersebut

            // Redirect setelah update selesai
            return redirect()
                ->route('admin.doctor-schedules.index')
                ->with('success', 'Jadwal dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani error dan redirect ke halaman sebelumnya
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($doctorId)
    {
        try {
            // Cari semua jadwal dokter berdasarkan doctor_id
            $schedules = DoctorSchedule::where('doctor_id', $doctorId)->get();

            // Hapus semua jadwal yang ditemukan
            foreach ($schedules as $schedule) {
                $schedule->delete();
            }

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('admin.doctor-schedules.index')
                ->with('success', 'Jadwal dokter berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika ada kesalahan, kembalikan dengan pesan error
            return redirect()->route('doctor-schedules.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
