<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        .bg {
            background: linear-gradient(135deg, #2ecc71, #27ae60, #1abc9c);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="{{ asset('logo/logo1.png') }}" type="image/png" sizes="16x16">
    <title>Absensi | Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body class="bg">
    <div class="container">

        <!-- Outer Row -->
        <div class="row min-vh-100 justify-content-center align-items-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12 d-">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Lupa Password</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan email" autocomplete="off">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-user btn-block text-white" style="background-color: #27ae60;">
                                            Kirim
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <p class="small text-gray-900">Kembali?
                                            <a href="{{ route('login') }}">Login</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

    <!-- SweeetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <!-- Sweetalerrt berhasil -->
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                // Hapus semua pesan error (text merah)
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.remove();
                });

                // Hapus semua border merah di input
                document.querySelectorAll('.is-invalid').forEach(input => {
                    input.classList.remove('is-invalid');
                });
            }, 3000); // 3 detik
        });
    </script>
</body>

</html>