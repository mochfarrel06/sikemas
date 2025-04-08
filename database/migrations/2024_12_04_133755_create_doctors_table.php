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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialization_id')->constrained()->onDelete('cascade');
            $table->string('kode_dokter')->unique();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('konfirmasi_password')->nullable();
            $table->string('no_hp');
            $table->date('tgl_lahir');
            $table->integer('pengalaman');
            $table->string('jenis_kelamin');
            $table->string('golongan_darah');
            $table->string('foto_dokter');
            $table->string('alamat');
            $table->string('negara');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kodepos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
