<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SuratIzinController as AdminSuratIzin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Karyawan\ScanController;
use App\Http\Controllers\Karyawan\SuratIzinController as KaryawanSuratIzin;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

// Logout
// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Anda telah berhasil logout.');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/profile', [AdminProfileController::class, 'profile'])->name('admin.users.profile');
    Route::put('/admin/profile/{id}', [AdminProfileController::class, 'profileUpdate'])->name('admin.profile.update');

    // Admin User Index
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

    // Admin Laporan Absensi
    Route::get('/admin/absensi', [AbsensiController::class, 'index'])->name('admin.absensi.index');

    // Admin User Create
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    // Admin User Edit
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    // Admin User Destroy
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Absensi
    Route::get('/admin/absensi/qrcode', [AbsensiController::class, 'generateQrCode'])->name('admin.qrcode');

    // Admin Surat Izin
    Route::get('/admin/surat-izin', [AdminSuratIzin::class, 'index'])->name('admin.suratizin.index');
    Route::get('/admin/surat-izin/{id}/lihat', [AdminSuratIzin::class, 'lihat'])->name('admin.suratizin.lihat');

    Route::put('/admin/surat-izin/{id}/disetujui', [AdminSuratIzin::class, 'setujui'])->name('admin.suratizin.setujui');
    Route::put('/admin/surat-izin/{id}/tolak', [AdminSuratIzin::class, 'tolak'])->name('admin.suratizin.tolak');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard Karyawan
    Route::get('/karyawan/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');

    // Karyawan Profile
    Route::get('/karyawan/profile', [AdminProfileController::class, 'profile'])->name('karyawan.profile');
    Route::put('/karyawan/profile/{id}', [AdminProfileController::class, 'profileUpdate'])->name('karyawan.profile.update');

    // Absen Index
    Route::get('/karyawan/absen', [ScanController::class, 'index'])->name('karyawan.absen.index');
    Route::post('/karyawan/absen/proses', [ScanController::class, 'proses'])->name('karyawan.absen.proses');

    // Histori Absen
    Route::get('/karyawan/absen/histori', [ScanController::class, 'histori'])->name('karyawan.absen.histori');

    // Karyawan Surat Izin
    Route::get('/karyawan/surat-izin', [KaryawanSuratIzin::class, 'index'])->name('karyawan.suratizin.index');
    Route::get('/karyawan/surat-izin/cetak/{id}', [KaryawanSuratIzin::class, 'cetak'])->name('karyawan.suratizin.cetak');

    // Karyawan Surat Create
    Route::get('/karyawan/surat-izin/create', [KaryawanSuratIzin::class, 'create'])->name('karyawan.suratizin.create');
    Route::post('/karyawan/surat-izin', [KaryawanSuratIzin::class, 'store'])->name('karyawan.suratizin.store');

    // Karyawan Surat Edit
    Route::get('/karyawan/surat-izin/{id}/edit', [KaryawanSuratIzin::class, 'edit'])->name('karyawan.suratizin.edit');
    Route::put('/karyawan/surat-izin/{id}', [KaryawanSuratIzin::class, 'update'])->name('karyawan.suratizin.update');

    Route::delete('/karyawan/surat-izin/{id}', [KaryawanSuratIzin::class, 'destroy'])->name('karyawan.suratizin.destroy');
});
