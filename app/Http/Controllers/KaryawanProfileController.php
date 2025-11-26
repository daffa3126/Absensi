<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('karyawan.profile', compact('user'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $user = User::findOrFail($id);

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('img/' . $user->foto))) {
                unlink(public_path('img/' . $user->foto));
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            // $file->move(public_path('img'), $filename);
            $file->move($_SERVER['DOCUMENT_ROOT'] . '/img', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('karyawan.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
