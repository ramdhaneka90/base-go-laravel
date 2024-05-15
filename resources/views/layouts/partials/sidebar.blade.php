<aside class="main-sidebar sidebar-dark-primary elevation-0">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link">
        <img src="{{ asset('img/favicon/favicon.ico') }}" alt="{{ config('app.client_name') }} Logo"
            class="brand-image img-circle elevation-3 bg-white p-1" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.client_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info pt-0">
                <a href="#" class="d-block">
                    <span class="text-white">{{ !empty(auth()->user()->name) ? auth()->user()->name : '-' }}</span>
                    <p class="small m-0">
                        {{ userRole()->name }}
                    </p>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                @if (!empty($menus))
                    @foreach ($menus as $menu)
                        <li class="nav-item">
                            @if ($menu['custom_url'] == '1')
                                <a href="{{ url($menu['url']) }}"
                                    class="nav-link {{ in_array($menu['slug'], $currentUrl) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-{{ $menu['icon'] }}"></i>
                                    <p>{!! isset($menu['children']) ? '<b>' . strtoupper($menu['label']) . '</b>' : $menu['label'] !!} {!! isset($menu['children']) && count($menu['children']) > 0 ? '<i class="right fas fa-angle-left"></i>' : '' !!}
                                    </p>
                                </a>
                                @if (isset($menu['children']))
                                    @include('layouts.partials.submenu', ['menus' => $menu['children']])
                                @endif
                            @else
                                <a href="{{ route($menu['url']) }}"
                                    class="nav-link {{ in_array($menu['slug'], $currentUrl) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-{{ $menu['icon'] }}"></i>
                                    <p>{{ $menu['label'] }}
                                    </p>
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@push('custom-scripts')
    <script>
        $(function() {
            initMenu()
        })
    </script>
@endpush
