<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'status_masuk',
        'waktu',
        'jam_keluar',
        'status_keluar'
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'tanggal' => 'date',
        // jam_masuk/jam_keluar kita biarkan string/time di DB; bisa diformat saat tampil
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
