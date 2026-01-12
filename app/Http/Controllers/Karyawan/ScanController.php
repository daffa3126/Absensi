<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function index()
    {
        return view('karyawan.absen.index');
    }

    public function proses(Request $request)
    {
        // Mengambil data user
        $user = Auth::user();
        $qrData = $request->input('data');

        // Memecah part jadi 3, Format: ABSEN|timestamp|hash
        $parts = explode('|', $qrData);
        if (count($parts) !== 3 || $parts[0] !== 'ABSEN') {
            return response()->json([
                'status' => 'error',
                'message' => 'Format QR tidak valid.'
            ]);
        }

        [$prefix, $timestamp, $hash] = $parts;
        $secretKey = 'rahasia-absensi';
        $expectedHash = hash('sha256', $timestamp . $secretKey);

        // Validasi hash
        if ($hash !== $expectedHash) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR tidak valid (hash salah).'
            ]);
        }

        // Validasi waktu (maks 3 detik)
        $now = now();
        $qrTime = Carbon::createFromFormat('YmdHis', $timestamp);
        // Menghitung selisih waktu dengan qr code jika lebih dari 3 detik maka qr code sudah kedaluwarsa
        if ($now->diffInSeconds($qrTime) > 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR sudah kedaluwarsa.'
            ]);
        }

        // Cek absensi hari ini
        $tanggal = $now->toDateString();
        $jamSekarang = $now->format('H:i:s');
        $absensiHariIni = Absensi::absensiHariIni($user->id, $tanggal);

        // === ABSEN MASUK ===
        if (!$absensiHariIni) {
            $absensi = new Absensi();
            // Menyimpan data ke table absensi
            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $tanggal,
                'jam_masuk' => $jamSekarang,
                'status_masuk' => $absensi->statusMasuk($jamSekarang),
                'waktu' => $now,
            ]);

            // Memberikan message success
            return response()->json([
                'status' => 'success',
                'message' => 'Absensi masuk berhasil dicatat'
            ]);
        }

        // === ABSEN KELUAR ===
        if (!$absensiHariIni->jam_keluar) {
            // mengecek apakah sudah waktunya jam pulang, kalo belum muncul error
            if (!$absensiHariIni->statusKeluar($jamSekarang)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Belum waktunya pulang.'
                ]);
            }

            // Set status keluar
            // Ambil waktu saat ini, dan mengubah ke format H:i:s jam menit detik
            $absensiHariIni->update([
                'jam_keluar' => $jamSekarang,
                'status_keluar' => 'Pulang',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Absensi keluar berhasil dicatat'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Anda sudah absen masuk & keluar hari ini.']);
    }

    public function histori(Request $request)
    {
        $user = Auth::user();

        Carbon::setLocale('id');

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $absensi = Absensi::where('user_id', $user->id)
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                $query->whereYear('tanggal', $tahun);
            })
            ->orderBy('waktu', 'desc')
            ->get();

        return view('karyawan.absen.histori', compact('absensi'));
    }
}
