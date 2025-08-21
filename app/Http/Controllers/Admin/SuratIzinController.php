<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratIzin;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratIzinController extends Controller
{
    public function index()
    {
        $surats = SuratIzin::with('user')->latest()->get();

        return view('admin.suratizin.index', compact('surats'));
    }

    public function setujui($id)
    {
        $surat = SuratIzin::findOrFail($id);
        $surat->status = 'disetujui';
        $surat->save();

        return redirect()->route('admin.suratizin.index')->with('success', 'Surat berhasil disetujui');
    }

    public function tolak($id)
    {
        $surat = SuratIzin::findOrFail($id);
        $surat->status = 'ditolak';
        $surat->save();

        return redirect()->route('admin.suratizin.index')->with('success', 'Surat berhasil ditolak.');
    }

    public function lihat($id)
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
