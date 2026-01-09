<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{

    public function statusMasuk($jamMasuk)
    {
        return $jamMasuk <= '08:00:00'
            ? 'Tepat Waktu'
            : 'Terlambat';
    }

    public function bolehPulang($jamSekarang)
    {
        return $jamSekarang >= '16:30:00';
    }

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

    public static function absensiHariIni($userId, $tanggal)
    {
        return self::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
