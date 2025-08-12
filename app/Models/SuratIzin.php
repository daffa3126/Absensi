<?php

namespace App\Models;

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
}
