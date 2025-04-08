<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization_id',
        'kode_dokter',
        'nama_depan',
        'nama_belakang',
        'email',
        'password',
        'konfirmasi_password',
        'no_hp',
        'tgl_lahir',
        'pengalaman',
        'jenis_kelamin',
        'golongan_darah',
        'foto_dokter',
        'alamat',
        'negara',
        'provinsi',
        'kota',
        'kodepos',
    ];

    public static function generateKodeDokterGigi()
    {
        $prefix = 'DG-';

        $lastDokter = self::where('kode_dokter', 'LIKE', $prefix . '%')
            ->orderBy('kode_dokter', 'desc')
            ->first();

        $lastNumber = $lastDokter ? (int)substr($lastDokter->kode_dokter, strlen($prefix)) : 0;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $uniqueCode = $prefix . $newNumber;

        return $uniqueCode;
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
