<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
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
        $user = Auth::user();
        $qrData = $request->input('data');

        // Format: ABSEN|timestamp|hash
        $parts = explode('|', $qrData);

        if (count($parts) !== 3 || $parts[0] !== 'ABSEN') {
            return response()->json(['status' => 'error', 'message' => 'Format QR tidak valid.']);
        }

        [$prefix, $timestamp, $hash] = $parts;

        $secretKey = 'rahasia-absensi';
        $expectedHash = hash('sha256', $timestamp . $secretKey);

        // Validasi hash
        if ($hash !== $expectedHash) {
            return response()->json(['status' => 'error', 'message' => 'QR tidak valid (hash salah).']);
        }

        // Validasi waktu (maks selisih 3 detik)
        $now = now();
        $qrTime = \Carbon\Carbon::createFromFormat('YmdHis', $timestamp);
        $diff = $now->diffInSeconds($qrTime);

        if ($diff > 3) {
            return response()->json(['status' => 'error', 'message' => 'QR sudah kedaluwarsa.']);
        }

        // Cari absensi hari ini
        $absensiHariIni = DB::table('absensis')
            ->where('user_id', $user->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        // Jam batas
        $jamTepatWaktu = '08:00:00';
        $jamPulang = '16:30:00';

        if (!$absensiHariIni) {
            // === ABSEN MASUK ===
            $statusMasuk = ($now->format('H:i:s') <= $jamTepatWaktu) ? 'Tepat Waktu' : 'Terlambat';

            DB::table('absensis')->insert([
                'user_id' => $user->id,
                'tanggal' => $now->toDateString(),
                'jam_masuk' => $now->format('H:i:s'),
                'status_masuk' => $statusMasuk,
                'waktu' => $now,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Absensi masuk berhasil dicatat'
            ]);
        }

        if ($absensiHariIni && !$absensiHariIni->jam_keluar) {
            // === ABSEN KELUAR ===
            if ($now->format('H:i:s') < $jamPulang) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang.']);
            }

            $statusKeluar = ($now->format('H:i:s') >= $jamPulang) ? 'Pulang Tepat Waktu' : 'Pulang Cepat';

            DB::table('absensis')
                ->where('id', $absensiHariIni->id)
                ->update([
                    'jam_keluar' => $now->format('H:i:s'),
                    'status_keluar' => $statusKeluar,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Absensi keluar berhasil dicatat'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Anda sudah absen masuk & keluar hari ini.']);
    }


    public function histori()
    {
        $user = Auth::user();

        // Ambil absensi user yang sedang login, urut terbaru
        $absensi = DB::table('absensis')
            ->where('user_id', $user->id)
            ->orderBy('waktu', 'desc')
            ->get();

        return view('karyawan.absen.histori', compact('absensi'));
    }
}
