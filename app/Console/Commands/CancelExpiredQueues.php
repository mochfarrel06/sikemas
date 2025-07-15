<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Queue;
use Carbon\Carbon;

class CancelExpiredQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:cancel-expired 
                            {--dry-run : Show what would be cancelled without actually cancelling}
                            {--days=0 : Number of days past the scheduled date to cancel (default: 0 = same day)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel expired queues that have passed their scheduled date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $daysOffset = (int) $this->option('days');
        
        // Tanggal batas (hari ini dikurangi offset hari)
        $cutoffDate = Carbon::now()->subDays($daysOffset)->toDateString();
        
        $this->info("Checking for expired queues before date: {$cutoffDate}");
        
        // Ambil antrian yang sudah lewat tanggal dan masih dalam status aktif
        $expiredQueues = Queue::where('tgl_periksa', '<', $cutoffDate)
            ->whereIn('status', ['booking', 'confirmed', 'waiting'])
            ->with(['user', 'doctor', 'patient'])
            ->get();

        if ($expiredQueues->isEmpty()) {
            $this->info('No expired queues found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$expiredQueues->count()} expired queue(s)");

        // Show table of expired queues
        $headers = ['ID', 'Patient', 'Doctor', 'Date', 'Time', 'Status', 'Queue Number'];
        $rows = [];

        foreach ($expiredQueues as $queue) {
            $rows[] = [
                $queue->id,
                $queue->patient->name ?? 'N/A',
                $queue->doctor->name ?? 'N/A',
                $queue->tgl_periksa,
                $queue->start_time . ' - ' . $queue->end_time,
                $queue->status,
                $queue->nomer_antrian ?? 'N/A'
            ];
        }

        $this->table($headers, $rows);

        if ($dryRun) {
            $this->warn('DRY RUN: No queues were actually cancelled.');
            return Command::SUCCESS;
        }

        // Konfirmasi sebelum melakukan pembatalan
        if (!$this->confirm('Do you want to cancel these expired queues?')) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }

        // Proses pembatalan
        $cancelledCount = 0;
        $bar = $this->output->createProgressBar($expiredQueues->count());
        $bar->start();

        foreach ($expiredQueues as $queue) {
            try {
                // Update status menjadi cancelled
                $queue->update([
                    'status' => 'cancelled',
                    'is_booked' => false,
                    'keterangan' => ($queue->keterangan ?? '') . ' [Auto-cancelled: Expired on ' . Carbon::now()->toDateTimeString() . ']'
                ]);

                $cancelledCount++;
                $bar->advance();

                // Log untuk debugging (optional)
                \Log::info("Queue ID {$queue->id} auto-cancelled due to expiration", [
                    'queue_id' => $queue->id,
                    'patient_id' => $queue->patient_id,
                    'doctor_id' => $queue->doctor_id,
                    'scheduled_date' => $queue->tgl_periksa,
                    'cancelled_at' => Carbon::now()->toDateTimeString()
                ]);

            } catch (\Exception $e) {
                $this->error("Failed to cancel queue ID {$queue->id}: " . $e->getMessage());
                \Log::error("Failed to cancel expired queue", [
                    'queue_id' => $queue->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully cancelled {$cancelledCount} expired queue(s).");

        return Command::SUCCESS;
    }
}