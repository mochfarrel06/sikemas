<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'queue_id',
        'tgl_periksa',
        'diagnosis',
        'tindakan',
        'resep',
        'catatan_medis',
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah'
    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medical_record_medicine');
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

}
