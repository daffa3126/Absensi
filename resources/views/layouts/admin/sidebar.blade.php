<!-- <ul class="navbar-nav sidebar text-dark accordion" id="accordionSidebar" style="background-color: #27ae60;"> -->
<ul class="navbar-nav bg-gradient-success sidebar text-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="nav-link sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
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
    <div class="sidebar-heading text-white">
        Menu Admin
    </div>
    <li class="nav-item {{ Request::is('admin/users') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-user text-white"></i>
            <span class="text-white">User</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/absensi') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.absensi.index') }}">
            <i class="fas fa-fw fa-clipboard-check text-white"></i>
            <span class="text-white">Laporan Absensi</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/surat-izin') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.suratizin.index') }}">
            <i class="fas fa-fw fa-envelope text-white"></i>
            <span class="text-white">Surat Karyawan</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>