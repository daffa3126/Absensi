<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratIzin;
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
}
