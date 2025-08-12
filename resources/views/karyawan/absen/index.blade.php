@extends('layouts.karyawan')

@section('title', 'Scan Absensi')

@section('content')
<div class="container mt-4">
    <h4>Scan QR Code untuk Absensi</h4>

    {{-- Tombol Switch Kamera --}}
    <button class="btn btn-secondary mb-3" id="btn-switch-camera" style="display: none;">
        Ganti Kamera (Depan ↔ Belakang)
    </button>

    <div id="reader" style="width: 300px;"></div>

    {{-- Tempat pesan loading atau error --}}
    <div id="hasil" class="mt-3"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let html5QrCode;
    let cameraList = [];
    let currentCameraIndex = 0;

    const btnSwitch = document.getElementById('btn-switch-camera');
    const hasilDiv = document.getElementById('hasil');

    function showLoading(message = "Memverifikasi...") {
        hasilDiv.innerHTML = `<div class="alert alert-info">${message}</div>`;
    }

    function clearLoading() {
        hasilDiv.innerHTML = "";
    }

    function onScanSuccess(decodedText, decodedResult) {
        html5QrCode.stop().then(() => {
            showLoading();

            fetch("{{ route('karyawan.absen.proses') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new URLSearchParams({
                        data: decodedText
                    })
                })
                .then(res => res.json())
                .then(res => {
                    clearLoading(); // hapus pesan memverifikasi

                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            startScanner(cameraList[currentCameraIndex].id);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message
                        }).then(() => {
                            startScanner(cameraList[currentCameraIndex].id);
                        });
                    }
                })
                .catch(err => {
                    clearLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Error',
                        text: err
                    }).then(() => {
                        startScanner(cameraList[currentCameraIndex].id);
                    });
                });
        });
    }

    function startScanner(cameraId) {
        html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            cameraId, {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        ).catch(err => {
            hasilDiv.innerHTML = `<div class="alert alert-danger">Gagal membuka kamera: ${err}</div>`;
        });
    }

    function switchCamera() {
        if (cameraList.length <= 1) return;

        currentCameraIndex = (currentCameraIndex + 1) % cameraList.length;

        html5QrCode.stop().then(() => {
            html5QrCode.clear();
            startScanner(cameraList[currentCameraIndex].id);
        });
    }

    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            cameraList = cameras;
            btnSwitch.style.display = 'inline-block';
            btnSwitch.addEventListener('click', switchCamera);

            startScanner(cameras[currentCameraIndex].id);
        } else {
            hasilDiv.innerHTML = `<div class="alert alert-danger">Tidak ada kamera terdeteksi</div>`;
        }
    }).catch(err => {
        hasilDiv.innerHTML = `<div class="alert alert-danger">Gagal mengakses kamera: ${err}</div>`;
    });
</script>
@endpush