<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link mb-3">
        <i class="nav-icon iconoir-hospital" style="font-size: 2rem; color: #0288D1"></i>
        <span class="brand-text font-weight-bold" style="color: #4A4A4A; font-weight: 800">DENTHIS PLUS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">UTAMA</li>
                <li class="nav-item mb-2 {{ request()->routeIs('admin.dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon iconoir-dashboard-speed"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item mb-2 {{ request()->routeIs('admin.doctors*') || request()->routeIs('admin.doctor-schedules.*') ? 'menu-open' : '' }}">
                    <a
                        class="nav-link {{ request()->routeIs('admin.doctors.*') || request()->routeIs('admin.doctor-schedules.*') ? 'active' : '' }}">
                        <i class="nav-icon iconoir-group"></i>
                        <p>
                            Dokter
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.doctors.index') }}"
                                class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dokter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.doctor-schedules.index') }}"
                                class="nav-link {{ request()->routeIs('admin.doctor-schedules.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Dokter</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mb-2 {{ request()->routeIs('admin.patients.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.patients.index') }}"
                        class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
                        <i class="nav-icon iconoir-user-square"></i>
                        <p>
                            Pasien
                        </p>
                    </a>
                </li>

                <li class="nav-header">ANTREAN</li>
                <li class="nav-item mb-2">
                    <a href="" class="nav-link">
                        <i class="nav-icon iconoir-task-list"></i>
                        <p>
                            Antrean Pasien
                        </p>
                    </a>
                </li>

                <li class="nav-header">LAINNYA</li>
                <li class="nav-item mb-2">
                    <a href="" class="nav-link">
                        <i class="nav-icon iconoir-group"></i>
                        <p>
                            Manajemen Pengguna
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
