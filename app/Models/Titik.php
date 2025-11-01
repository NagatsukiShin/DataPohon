<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titik extends Model
{
    use HasFactory;

    protected $table = 'titik'; // pastikan sesuai migration
    protected $fillable = [
        'nama_titik',
        'latitude',
        'longitude',
        'hasil',
        'waktu_panen',
        'estimasi_panen',
        'terakhir_pemupukan',
        'jenis_pupuk',
        'jumlah_pupuk',
        'edited_by'
    ];

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }


    // protected $casts = [
    //     'waktu_panen' => 'date',
    //     'terakhir_pemupukan' => 'date',
    // ];
}
