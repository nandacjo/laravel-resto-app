<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->

        <!-- Menu Dashboard -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Menu Dashboard -->

        <!-- Menu Category -->
        <li class="nav-item">
            <a href="{{ route('category') }}" class="nav-link {{ request()->is('category') ? 'active' : '' }}">
                <i class="nav-icon fas fa-address-book"></i>
                <p>
                    Kategori
                </p>
            </a>
        </li>
        <!-- End Menu Category -->

        <!-- Menu User -->
        <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-alt"></i>
                <p>
                    User
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                </p>
            </a>
        </li>
        <!-- End Menu User -->

    </ul>
</nav>
