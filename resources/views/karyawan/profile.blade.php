@extends('layouts.karyawan')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>
    <form action="{{ route('karyawan.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Foto Profil</label><br>
            <img id="preview-image"
                src="{{ $user->foto ? asset('img/' . $user->foto) : asset('img/default.png') }}"
                alt="Foto Profil"
                width="100"
                class="mb-2"
                style="display: block;">

            <input type="file" name="foto" id="foto-input"
                class="form-control-file @error('foto') is-invalid @enderror"
                accept="image/*">
            @error('foto')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success text-white">Simpan</button>
        <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    document.getElementById('foto-input').addEventListener('change', function(event) {
        const image = document.getElementById('preview-image');
        const file = event.target.files[0];
        if (file && image) {
            image.src = URL.createObjectURL(file);
        }
    });
</script>
@endsection