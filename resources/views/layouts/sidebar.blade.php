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
                @foreach (config('sidebar') as $item)
                    @if (isset($item['is_header']) && $item['is_header'] && in_array(auth()->user()->role, $item['role']))
                        <!-- Menampilkan Header (seperti UTAMA) -->
                        <li class="nav-header">{{ $item['text'] }}</li>
                    @elseif (!isset($item['is_header']) && in_array(auth()->user()->role, $item['role']))
                        <li
                            class="nav-item mb-2 {{ (is_array($item['url']) && array_filter($item['url'], fn($url) => request()->is(ltrim($url, '/') . '*'))) || (!is_array($item['url']) && request()->is(ltrim($item['url'], '/') . '*')) ? 'menu-open' : '' }}">
                            <a href="{{ url(is_array($item['url']) ? $item['url'][0] : $item['url']) }}"
                                class="nav-link {{ (is_array($item['url']) && array_filter($item['url'], fn($url) => request()->is(ltrim($url, '/') . '*'))) || (!is_array($item['url']) && request()->is(ltrim($item['url'], '/') . '*')) ? 'active' : '' }}">
                                <i class="nav-icon {{ $item['icon'] }}"></i>
                                <p>
                                    {{ $item['text'] }}
                                    @isset($item['children'])
                                        <i class="right fas fa-angle-left"></i>
                                    @endisset
                                </p>
                            </a>
                            @isset($item['children'])
                                <ul class="nav nav-treeview">
                                    @foreach ($item['children'] as $child)
                                        @if (in_array(auth()->user()->role, $child['role']))
                                            <li class="nav-item">
                                                <a href="{{ url($child['url']) }}"
                                                    class="nav-link {{ request()->is(ltrim($child['url'], '/') . '*') ? 'active' : '' }}">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ $child['text'] }}</p>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endisset
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
