<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            return view('karyawan.dashboard');
        }
    }
}
