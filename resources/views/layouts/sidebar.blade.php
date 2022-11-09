<nav class="main-sidebar ps-menu">
    <div class="sidebar-toggle action-toggle">
        <a href="#">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <div class="sidebar-opener action-toggle">
        <a href="#">
            <i class="ti-angle-right"></i>
        </a>
    </div>
    <div class="sidebar-header">
        <div class="text">MJ-Motor</div>
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li class="{{request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @foreach (getMenusSidebar() as $menu)
            <li class="{{request()->segment(1) == $menu->url ? 'active open' : '' }}">
                <a href="#" class="main-menu has-dropdown">
                    <i class="{{$menu->icon}}"></i>
                    <span>{{$menu->name}}</span>
                </a>
                <ul class="sub-menu {{request()->segment(1) == $menu->url ? 'expand' : '' }}">
                    @foreach ($menu->subMenus as $subMenu)
                    <li
                        class="{{request()->segment(1) == explode('/', $subMenu->url)[0] && request()->segment(2) == explode( '/', $subMenu->url)[1] ? 'active' : '' }}">
                        <a href="{{url($subMenu->url)}}" class="link"><span>{{$subMenu->name}}</span></a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
</nav>