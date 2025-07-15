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
                            {--days=0 : Number of days past the scheduled date to cancel (default: 0 = expired today)}
                            {--silent : Run silently without output}';

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
        $silent = $this->option('silent');
        
        // Tanggal batas (hari ini dikurangi offset hari)
        $cutoffDate = Carbon::now()->subDays($daysOffset)->toDateString();
        
        if (!$silent) {
            $this->info("Checking for expired queues before date: {$cutoffDate}");
        }
        
        // Ambil antrian yang sudah lewat tanggal dan masih dalam status aktif
        $expiredQueues = Queue::where('tgl_periksa', '<', $cutoffDate)
            ->whereIn('status', ['booking', 'confirmed', 'waiting'])
            ->with(['user', 'doctor', 'patient'])
            ->get();

        if ($expiredQueues->isEmpty()) {
            if (!$silent) {
                $this->info('No expired queues found.');
            }
            return Command::SUCCESS;
        }

        if (!$silent) {
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
        }

        if ($dryRun) {
            if (!$silent) {
                $this->warn('DRY RUN: No queues were actually cancelled.');
            }
            return Command::SUCCESS;
        }

        // Langsung proses pembatalan tanpa konfirmasi
        if (!$silent) {
            $this->info('Processing automatic cancellation of expired queues...');
        }

        // Proses pembatalan
        $cancelledCount = 0;
        $bar = null;
        
        if (!$silent) {
            $bar = $this->output->createProgressBar($expiredQueues->count());
            $bar->start();
        }

        foreach ($expiredQueues as $queue) {
            try {
                // Update status menjadi cancelled
                $queue->update([
                    'status' => 'cancelled',
                    'is_booked' => false,
                    'keterangan' => ($queue->keterangan ?? '') . ' [Auto-cancelled: Expired on ' . Carbon::now()->toDateTimeString() . ']'
                ]);

                $cancelledCount++;
                
                if ($bar) {
                    $bar->advance();
                }

                // Log untuk debugging (optional)
                \Log::info("Queue ID {$queue->id} auto-cancelled due to expiration", [
                    'queue_id' => $queue->id,
                    'patient_id' => $queue->patient_id,
                    'doctor_id' => $queue->doctor_id,
                    'scheduled_date' => $queue->tgl_periksa,
                    'cancelled_at' => Carbon::now()->toDateTimeString()
                ]);

            } catch (\Exception $e) {
                if (!$silent) {
                    $this->error("Failed to cancel queue ID {$queue->id}: " . $e->getMessage());
                }
                \Log::error("Failed to cancel expired queue", [
                    'queue_id' => $queue->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if ($bar) {
            $bar->finish();
            $this->newLine();
        }
        
        if (!$silent) {
            $this->info("Successfully cancelled {$cancelledCount} expired queue(s).");
        }

        // Log summary untuk monitoring
        \Log::info("Auto-cancellation completed", [
            'total_found' => $expiredQueues->count(),
            'successfully_cancelled' => $cancelledCount,
            'cutoff_date' => $cutoffDate,
            'executed_at' => Carbon::now()->toDateTimeString()
        ]);

        return Command::SUCCESS;
    }
}