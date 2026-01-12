<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratIzin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis',
        'alasan',
        'status',
    ];

    // Relasi: satu surat izin milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormatTanggalAttribute()
    {
        return Carbon::parse($this->tanggal)
            ->locale('id')
            ->translatedFormat('d F Y');
    }

    public function getStatusViewAttribute()
    {
        return match ($this->status) {
            'disetujui' => [
                'label' => 'Disetujui',
                'badge' => 'success'
            ],
            'belum disetujui' => [
                'label' => 'Belum Disetujui',
                'badge' => 'warning'
            ],
            default => [
                'label' => 'Ditolak',
                'badge' => 'danger'
            ],
        };
    }

    public function bisaDiproses()
    {
        return $this->status === 'belum disetujui';
    }
}
