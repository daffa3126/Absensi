<ul class="navbar-nav sidebar text-dark accordion" id="accordionSidebar" style="background-color: #E0E0E0;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-clipboard-check text-dark"></i>
        </div>
        <div class="sidebar-brand-text text-dark mx-3">Absensi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
            <span class="text-dark">Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Admin
    </div>
    <li class="nav-item {{ Request::is('karyawan/absen') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.absen.index') }}">
            <i class="fas fa-fw fa-qrcode text-dark"></i>
            <span class="text-dark">Qr Absen</span></a>
    </li>
    <li class="nav-item {{ Request::is('karyawan/absen/histori') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.absen.histori') }}">
            <i class="fas fa-fw fa-clock text-dark"></i>
            <span class="text-dark">Histori Absen</span></a>
    </li>
    <li class="nav-item {{ Request::is('karyawan/surat-izin') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('karyawan.suratizin.index') }}">
            <i class="fas fa-fw fa-envelope text-dark"></i>
            <span class="text-dark">Surat</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>