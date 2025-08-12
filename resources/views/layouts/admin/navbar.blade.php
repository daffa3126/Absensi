<nav class="navbar navbar-expand topbar mb-4 static-top shadow" style="background-color: #1A1A1A;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 bars-menu">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-none d-inline text-white small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('sbadmin2/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in user-dropdown-menu" aria-labelledby="userDropdown">
                <div class="d-flex justify-content-center mt-2">
                    @if(Auth::user()->role === 'admin')
                    <span class="badge badge-success mb-2" style="padding: 0.5em 1em;">{{ Auth::user()->role }}</span>
                    @else
                    <span class=" badge badge-secondary mb-2" style="padding: 0.5em 1em;">{{ Auth::user()->role }}</span>
                    @endif
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0 m-0">
                    @csrf
                    <button type="submit" class="btn btn-link dropdown-item btn-logout">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>

    </ul>

</nav>