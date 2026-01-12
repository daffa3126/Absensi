<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Absensi extends Model
{
    // Set waktu status masuk
    public function statusMasuk($jamMasuk)
    {
        return $jamMasuk <= '08:00:00'
            ? 'Tepat Waktu'
            : 'Terlambat';
    }

    // Set waktu status keluar
    public function statusKeluar($jamKeluar)
    {
        return $jamKeluar >= '15:00:00';
    }

    // Mengatur format tanggal
    public function getFormatTanggalAttribute()
    {
        return Carbon::parse($this->tanggal)
            ->locale('id')
            ->translatedFormat('d F Y');
    }

    // Set badge status masuk
    public function getStatusMasukBadgeAttribute()
    {
        return $this->status_masuk === 'Tepat Waktu'
            ? 'success'
            : 'warning';
    }

    public function getStatusKeluarViewAttribute()
    {
        if (!$this->status_keluar) {
            if (Carbon::parse($this->tanggal)->isBefore(Carbon::today())) {
                return [
                    'label' => 'Tidak Absen',
                    'badge' => 'danger'
                ];
            }

            return null;
        }

        return [
            'label' => $this->status_keluar,
            'badge' => 'success'
        ];
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
