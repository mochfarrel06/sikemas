<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'doctor_id',
        'queue_id',
        'tgl_periksa',
        'diagnosis',
        'resep',
        'catatan_medis',
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah'
        // 'medicine_id',

        // Kolom hasil laboratorium
    // 'gula_darah_acak',
    // 'gula_darah_puasa',
    // 'gula_darah_2jm_pp',
    // 'analisa_lemak',
    // 'cholesterol',
    // 'trigliserida',
    // 'hdl',
    // 'ldl',
    // 'asam_urat',
    // 'bun',
    // 'creatinin',
    // 'sgot',
    // 'sgpt',
    // 'warna',
    // 'ph',
    // 'berat_jenis',
    // 'reduksi',
    // 'protein',
    // 'bilirubin',
    // 'urobilinogen',
    // 'nitrit',
    // 'keton',
    // 'sedimen_lekosit',
    // 'sedimen_eritrosit',
    // 'sedimen_epitel',
    // 'sedimen_kristal',
    // 'sedimen_bakteri',
    // 'hemoglobin',
    // 'leukosit',
    // 'erytrosit',
    // 'trombosit',
    // 'pcv',
    // 'dif',
    // 'bleeding_time',
    // 'clotting_time',
    // 'salmonella_o',
    // 'salmonella_h',
    // 'salmonella_p_a',
    // 'salmonella_p_b',
    // 'hbsag',
    // 'vdrl',
    // 'plano_test',
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
