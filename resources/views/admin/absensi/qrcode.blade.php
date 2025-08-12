@php
$timestamp = now()->format('YmdHis');
$secretKey = 'rahasia-absensi';
$hash = hash('sha256', $timestamp . $secretKey);
$data = "ABSEN|{$timestamp}|{$hash}";
@endphp

{!! QrCode::size(200)->generate($data) !!}