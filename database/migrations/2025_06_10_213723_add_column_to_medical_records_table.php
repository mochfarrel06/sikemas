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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('gula_darah_acak')->nullable();
            $table->string('gula_darah_puasa')->nullable();
            $table->string('gula_darah_2jm_pp')->nullable();
            $table->string('analisa_lemak')->nullable();
            $table->string('cholesterol')->nullable();
            $table->string('trigliserida')->nullable();
            $table->string('hdl')->nullable();
            $table->string('ldl')->nullable();
            $table->string('asam_urat')->nullable();
            $table->string('bun')->nullable();
            $table->string('creatinin')->nullable();
            $table->string('sgot')->nullable();
            $table->string('sgpt')->nullable();
            $table->string('warna')->nullable();
            $table->string('ph')->nullable();
            $table->string('berat_jenis')->nullable();
            $table->string('reduksi')->nullable();
            $table->string('protein')->nullable();
            $table->string('bilirubin')->nullable();
            $table->string('urobilinogen')->nullable();
            $table->string('nitrit')->nullable();
            $table->string('keton')->nullable();
            $table->string('sedimen_lekosit')->nullable();
            $table->string('sedimen_eritrosit')->nullable();
            $table->string('sedimen_epitel')->nullable();
            $table->string('sedimen_kristal')->nullable();
            $table->string('sedimen_bakteri')->nullable();
            $table->string('hemoglobin')->nullable();
            $table->string('leukosit')->nullable();
            $table->string('erytrosit')->nullable();
            $table->string('trombosit')->nullable();
            $table->string('pcv')->nullable();
            $table->string('dif')->nullable();
            $table->string('bleeding_time')->nullable();
            $table->string('clotting_time')->nullable();
            $table->string('salmonella_o')->nullable();
            $table->string('salmonella_h')->nullable();
            $table->string('salmonella_p_a')->nullable();
            $table->string('salmonella_p_b')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('vdrl')->nullable();
            $table->string('plano_test')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            //
        });
    }
};
