<ul class="navbar-nav sidebar text-white accordion" id="accordionSidebar" style="background-color: #27ae60;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-clipboard-check text-white"></i>
        </div>
        <div class="sidebar-brand-text text-white mx-3">Absensi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" style="background-color: white;">


    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span class="text-white">Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" style="background-color: white;">


    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Admin
    </div>
    <li class="nav-item {{ Request::is('karyawan/absen') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.absen.index') }}">
            <i class="fas fa-fw fa-qrcode text-white"></i>
            <span class="text-white">Qr Absen</span></a>
    </li>
    <li class="nav-item {{ Request::is('karyawan/absen/histori') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.absen.histori') }}">
            <i class="fas fa-fw fa-clock text-white"></i>
            <span class="text-white">Histori Absen</span></a>
    </li>
    <li class="nav-item {{ Request::is('karyawan/surat-izin') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.suratizin.index') }}">
            <i class="fas fa-fw fa-envelope text-white"></i>
            <span class="text-white">Surat</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>