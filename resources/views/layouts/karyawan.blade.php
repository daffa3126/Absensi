<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('logo/logo1.png') }}" type="image/png" sizes="16x16">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('sbadmin2/css/custom.css') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        @include('layouts.karyawan.sidebar')

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                @include('layouts.karyawan.navbar')

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.karyawan.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

    <!-- Data Tables -->
    <script src="{{ asset('sbadmin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script> -->

    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: "OK"
        });
    </script>
    @endif
    <!-- Sweetalert konfirmasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Yakin ingin menghapus data?",
                        text: "Silahkan cek kembali sebelum menghapus.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus Data!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-logout');
            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Yakin ingin keluar?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btn.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>

    <!-- Script untuk idle di web auto logout -->
    <script>
        let idleTime = 0;
        const idleLimit = 10 * 60 * 1000; // 10 menit dalam ms

        function resetTimer() {
            clearTimeout(window.idleTimer);
            window.idleTimer = setTimeout(() => {
                // redirect ke logout
                window.location.href = "{{ route('logout') }}?expired=1";
            }, idleLimit);
        }

        // reset timer kalau ada aktivitas
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.onclick = resetTimer;
        document.onscroll = resetTimer;
    </script>

    <!-- PLUGIN QR CODE -->

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>