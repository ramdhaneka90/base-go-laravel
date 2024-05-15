@if (isset($menus))
    
<ul class="nav nav-treeview">
    @foreach ($menus as $menu)
        <li class="nav-item">
            <a href="{{ $menu['url'] != '#' ? url($menu['url']) : $menu['url'] }}" class="nav-link {{ in_array($menu['slug'],$currentUrl) ? 'active' : '' }}">
                <i class="fas fa-{{ $menu['icon'] }} nav-icon"></i>
                <p>{{ $menu['label'] }}</p>
            </a>
        </li>
    @endforeach
</ul>
@endif