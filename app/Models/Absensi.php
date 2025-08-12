<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id',
        'kode_qr',
        'status',
        'waktu',
        'valid',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status_masuk',
        'status_keluar'
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'tanggal' => 'date',
        // jam_masuk/jam_keluar kita biarkan string/time di DB; bisa diformat saat tampil
    ];
}
