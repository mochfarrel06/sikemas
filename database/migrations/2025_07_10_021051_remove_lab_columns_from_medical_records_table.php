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
            $table->dropColumn([
                'gula_darah_acak',
                'gula_darah_puasa',
                'gula_darah_2jm_pp',
                'analisa_lemak',
                'cholesterol',
                'trigliserida',
                'hdl',
                'ldl',
                'asam_urat',
                'bun',
                'creatinin',
                'sgot',
                'sgpt',
                'warna',
                'ph',
                'berat_jenis',
                'reduksi',
                'protein',
                'bilirubin',
                'urobilinogen',
                'nitrit',
                'keton',
                'sedimen_lekosit',
                'sedimen_eritrosit',
                'sedimen_epitel',
                'sedimen_kristal',
                'sedimen_bakteri',
                'hemoglobin',
                'leukosit',
                'erytrosit',
                'trombosit',
                'pcv',
                'dif',
                'bleeding_time',
                'clotting_time',
                'salmonella_o',
                'salmonella_h',
                'salmonella_p_a',
                'salmonella_p_b',
                'hbsag',
                'vdrl',
                'plano_test',
            ]);
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
