<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $absensi = DB::table('absensis')
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->select(
                'users.name as nama_user',
                'absensis.tanggal',
                'absensis.jam_masuk',
                'absensis.status_masuk',
                'absensis.jam_keluar',
                'absensis.status_keluar'
            )
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                $query->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.absensi.index', compact('absensi'));
    }


    public function generateQrCode()
    {
        // 1. Buat kode unik berbasis waktu
        $timestamp = now()->timestamp;
        $secretKey = 'rahasia-absensi';
        $kodeQr = hash('sha256', $timestamp . $secretKey);

        // 2. Kirim ke view
        return view('admin.absensi.qrcode', compact('kodeQr'));
    }
}
