@extends('layouts.karyawan')

@section('title', 'Tambah Surat Izin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Ajukan Surat Izin</h1>
    <form action="{{ route('karyawan.suratizin.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="tanggal">Tanggal Izin</label>
            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
            @error('tanggal')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis">Jenis Izin</label>
            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                <option value="" disabled selected>-- Pilih Jenis Izin --</option>
                <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
            </select>
            @error('jenis')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="alasan">Alasan / Keterangan</label>
            <textarea name="alasan" rows="4" class="form-control @error('alasan') is-invalid @enderror" placeholder="Tulis keterangan singkat">{{ old('alasan') }}</textarea>
            @error('alasan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('karyawan.suratizin.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection