<?php

namespace App\Console;

use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Kirim pesan 10 menit sebelum periksa
        $schedule->call(function () {
            $this->sendWhatsAppReminder(+10);
        })->everyMinute();

        // Kirim pesan saat waktu periksa
        $schedule->call(function () {
            $this->sendWhatsAppReminder(0);
        })->everyMinute();

        $schedule->call(function () {
            $appointments = Queue::where('tgl_periksa', today())
                ->where('start_time', '<=', Carbon::now()->subMinutes(60)->format('H:i'))
                ->whereNotIn('status', ['selesai', 'batal'])
                ->get();

            foreach ($appointments as $appointment) {
                $appointment->update(['status' => 'batal']);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function sendWhatsAppReminder($minutesBefore)
    {
        $appointments = Queue::where('tgl_periksa', today())
            ->where('start_time', Carbon::now()->addMinutes($minutesBefore)->format('H:i'))
            ->get();

        foreach ($appointments as $appointment) {
            $phone = $appointment->patient->no_hp; // Pastikan ini ada di database
            $message = ($minutesBefore == 0)
                ? "Halo {$appointment->patient_name}, waktunya untuk pemeriksaan! Silakan datang ke lokasi."
                : "Halo {$appointment->patient_name}, antrean Anda kurang 10 menit lagi. Mohon bersiap.";

            // Kirim pesan ke WhatsApp menggunakan API Fonnte
            $this->sendWhatsAppMessage($phone, $message);

            if ($minutesBefore == 0) {
                $appointment->update(['status' => 'periksa']);
            }
        }
    }

    protected function sendWhatsAppMessage($phone, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'QPwX1ySyYbPhmV4MAzJ8', // Ganti dengan API Key Fonnte
            'Content-Type'  => 'application/json',
        ])->post('https://api.fonnte.com/send', [
            'target'      => $phone,
            'message'     => $message,
            'countryCode' => '62', // Indonesia
        ]);

        return $response->json();
    }
}
