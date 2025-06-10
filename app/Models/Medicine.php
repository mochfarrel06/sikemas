<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

}
