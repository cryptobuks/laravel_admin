<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{--<a href="/bower_components/admin-lte/index3.html" class="brand-link">
        <img src="/bower_components/admin-lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>--}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/bower_components/admin-lte/dist/img/my.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                {{--<li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa fa-table"></i>
                        <p>
                            Starter Pages
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('/') }}" class="nav-link @if($request_path == "/admin") active @endif">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.test') }}" class="nav-link @if($request_path == "/admin/test") active @endif">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Test</p>
                            </a>
                        </li>
                    </ul>
                </li>--}}

                @foreach($menu_list as $menu)
                    <li class="nav-item has-treeview @if($menu_group == $menu['group']) menu-open @endif">
                        <a href="#" class="nav-link @if($menu_group == $menu['group']) active @endif">
                            <i class="nav-icon fa {{ $menu['icon'] }}"></i>
                            <p>
                                {{ $menu['name'] }}
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach($menu['sub_menu'] as $sub_menu)
                                <li class="nav-item">
                                    <a href="{{ $sub_menu['link'] }}" class="nav-link @if($request_path == $sub_menu['link']) active @endif">
                                        <i class="fa {{ $sub_menu['icon'] }} nav-icon"></i>
                                        <p>{{ $sub_menu['name'] }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                {{--<li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            Simple Link
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>--}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>