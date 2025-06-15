<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'user_id',
        'patient_id',
        'tgl_periksa',
        'start_time',
        'end_time',
        'keterangan',
        'status',
        'is_booked',
        'waktu_mulai',
        'waktu_selesai',
        'medical_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalRecord()
    {
    return $this->hasOne(MedicalRecord::class, 'queue_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'user_id', 'patient_id');
    }

}
