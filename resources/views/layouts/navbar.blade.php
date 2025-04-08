<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" role="button">
                <img src="{{ asset('assets/admin/dist/img/avatar.png') }}" alt="User Profile"
                    class="img-circle elevation-2" style="width: 40px; height: 40px;">

                <div class="ml-2 d-flex flex-column" style="max-width: 120px;">
                    <!-- Nama dengan ellipsis jika terlalu panjang -->
                    <span class="text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                        data-toggle="tooltip" title="{{ auth()->user()->nama_depan }}">
                        {{ auth()->user()->nama_depan }}
                    </span>
                    <!-- Role pengguna -->
                    <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profile.profile.index') }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('login.destroy') }}">
                    @csrf
                    <a href="" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
