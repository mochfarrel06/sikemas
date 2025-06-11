<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropForeign(['medicine_id']); // Jika medicine_id sebelumnya foreign key
            $table->dropColumn('medicine_id');
        });
    }

    public function down()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->unsignedBigInteger('medicine_id')->nullable();

            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('set null');
        });
    }
};
