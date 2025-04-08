<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queue_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('queue_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pendaftar antrean
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('cascade');

            $table->date('tgl_periksa');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('keterangan');
            $table->string('status'); // status seperti "selesai" atau "dibatalkan"
            $table->boolean('is_booked');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_histories');
    }
};
