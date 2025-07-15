<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordMedicine extends Model
{
    use HasFactory;

    protected $table = 'medical_record_medicine';

    protected $fillable = [
        'medical_record_id',
        'medicine_id',
        'usage_instruction', // <= ini ditambahkan

    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
