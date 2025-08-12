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
    <li class="nav-item {{ Request::is('admin/users') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-user text-dark"></i>
            <span class="text-dark">User</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/absensi') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.absensi.index') }}">
            <i class="fas fa-fw fa-clipboard-check text-dark"></i>
            <span class="text-dark">Laporan Absensi</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/surat-izin') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('admin.suratizin.index') }}">
            <i class="fas fa-fw fa-envelope text-dark"></i>
            <span class="text-dark">Surat Karyawan</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>