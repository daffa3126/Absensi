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
            ->orderBy('tanggal', 'desc')
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
            'tanggal' => 'required|date',
            'jenis' => 'required|in:sakit,izin',
            'alasan' => 'required|string'
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
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
        $surat = SuratIzin::where('id', $id)
            ->where('user_id', Auth::user())
            ->with('user')
            ->firstOrFail();

        $html = view('karyawan.suratizin.cetak', compact('surat'))->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download('surat-izin-' . $surat->user->name . '.pdf');
    }
}
