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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('queue_id')->constrained()->onDelete('cascade');
            $table->date('tgl_periksa');
            $table->text('diagnosis');
            $table->text('resep');
            $table->text('catatan_medis')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
