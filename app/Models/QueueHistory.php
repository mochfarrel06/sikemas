<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'queue_id', 'user_id', 'doctor_id', 'patient_id',
        'tgl_periksa', 'start_time', 'end_time', 'keterangan',
        'status', 'is_booked'
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
