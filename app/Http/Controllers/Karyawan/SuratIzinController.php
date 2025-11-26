<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\SuratIzin;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratIzinController extends Controller
{
    public function index()
    {
        // Ambil data surat milik karyawan yang sedang login
        $surats = SuratIzin::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.suratizin.index', compact('surats'));
    }

    public function create()
    {
        return view('karyawan.suratizin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // After or equal validasi untuk memastikan tanggal tidak di masa lalu
            'tanggal' => 'required|date|after_or_equal:today',
            'jenis' => 'required|in:sakit,izin',
            'alasan' => 'required|string'
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini',
            'jenis.required' => 'Jenis surat harus diisi',
            'alasan.required' => 'Alasan harus diisi'
        ]);

        SuratIzin::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'status' => 'belum disetujui' // default: belum disetujui
        ]);

        return redirect()->route('karyawan.suratizin.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $surat = SuratIzin::findOrFail($id);
        return view('karyawan.suratizin.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:sakit,izin',
            'alasan' => 'required|string'
        ]);

        $surat = SuratIzin::findOrFail($id);
        $surat->tanggal = $request->tanggal;
        $surat->jenis = $request->jenis;
        $surat->alasan = $request->alasan;

        $surat->save();

        return redirect()->route('karyawan.suratizin.index')->with('success', 'Surat berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = SuratIzin::findOrFail($id);
        $surat->delete();

        return redirect()->route('karyawan.suratizin.index')->with('success', 'Surat berhasil dihapus');
    }

    public function cetak($id)
    {
        Carbon::setLocale('id');

        $surat = SuratIzin::with('user')->findOrFail($id);

        try {
            // Render view menjadi HTML
            $html = view('karyawan.suratizin.cetak', compact('surat'))->render();

            // Gunakan DomPDF core langsung, bukan Laravel package
            $dompdf = new \Dompdf\Dompdf([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'isRemoteEnabled' => false,
                'tempDir' => storage_path('app/temp'),
                'fontDir' => storage_path('fonts'),
                'chroot' => public_path(),
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Stream PDF
            return response($dompdf->output())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="surat-izin-' . $surat->user->name . '.pdf"');
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }
}
