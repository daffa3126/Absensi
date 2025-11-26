<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUser = User::count();
            return view('admin.dashboard', compact('totalUser'));
        } else {
            $totalAbsensiBulanIni = Absensi::where('user_id', $user->id)
                ->whereYear('tanggal', date('Y'))
                ->whereMonth('tanggal', date('m'))
                ->count();

            $namaBulan = Carbon::now()->locale('id')->isoFormat('MMMM');

            return view('karyawan.dashboard', compact('totalAbsensiBulanIni', 'namaBulan'));
        }
    }
}
