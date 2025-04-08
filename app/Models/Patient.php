<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_pasien',
        'nama_depan',
        'nama_belakang',
        'email',
        'password',
        'konfirmasi_password',
        'no_hp',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'negara',
        'provinsi',
        'kota',
        'kodepos'
    ];

    public static function generateKodePasien()
    {
        $prefix = 'PS-';

        $lastPasien = self::where('kode_pasien', 'LIKE', $prefix . '%')
            ->orderBy('kode_pasien', 'desc')
            ->first();

        $lastNumber = $lastPasien ? (int)substr($lastPasien->kode_pasien, strlen($prefix)) : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $uniqueCode = $prefix . $newNumber;

        return $uniqueCode;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
