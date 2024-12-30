<div class="overlay"></div>
<div class="sidebar-wrapper" style="z-index: 999999">
    <div class="sidebar-header position-relative">
        {{-- d-flex justify-content-between align-items-center --}}
        <div class="d-block text-center">
            <div class="logo mt-3 mt-xl-0">
                @php
                $logo = asset('assets/static/images/logo/logo.svg');
                $logoSetting = \App\Models\Setting::where('key', 'app_logo')->value('value');

                if ($logoSetting) {
                $logo = asset('storage/' . $logoSetting);
                }
                @endphp
                <a href="{{ url('/') }}"><img src="{{ $logo }}" alt="Logo"></a>
            </div>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @can('view_users')
            <li class="sidebar-item has-sub {{ Route::is('admin.users.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
                <ul class="submenu {{ Route::is('admin.users.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_users')
                    <li class="submenu-item {{ Route::is('admin.users.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}">User List</a>
                    </li>
                    @endcan
                    @can('create_user')
                    <li class="submenu-item {{ Route::is('admin.users.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.create') }}">Add User</a>
                    </li>
                    @endcan
                    @can('view_roles')
                    <li class="submenu-item {{ Route::is('admin.users.roles.index') || Route::is('admin.users.roles.show') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.roles.index') }}">Role & Permission</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('view_brand')
            <li class="sidebar-item has-sub {{ Route::is('admin.brands.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Brand</span>
                </a>
                <ul class="submenu {{ Route::is('admin.brands.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_brand')
                    <li class="submenu-item {{ Route::is('admin.brands.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.brands.index') }}">Brand List</a>
                    </li>
                    @endcan
                    @can('create_brand')
                    <li class="submenu-item {{ Route::is('admin.brands.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.brands.create') }}">Add Brand</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_category')
            <li class="sidebar-item has-sub {{ Route::is('admin.categories.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Category</span>
                </a>
                <ul class="submenu {{ Route::is('admin.categories.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_category')
                    <li class="submenu-item {{ Route::is('admin.categories.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}">Category List</a>
                    </li>
                    @endcan
                    @can('create_category')
                    <li class="submenu-item {{ Route::is('admin.categories.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.create') }}">Add Category</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_settings')
            <li class="sidebar-item has-sub {{ Route::is('admin.settings.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
                <ul class="submenu {{ Route::is('admin.settings.*') ? 'submenu-open' : 'submenu-close' }}">
                    <li
                        class="submenu-item {{ Route::currentRouteName() === 'admin.settings.edit' && request()->segment(3) === 'general-settings' ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.edit', 'general-settings') }}">General Settings</a>
                    </li>
                    <li
                        class="submenu-item {{ Route::currentRouteName() === 'admin.settings.edit' && request()->segment(3) === 'email-settings' ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.edit', 'email-settings') }}">Email Settings</a>
                    </li>
                    <li
                        class="submenu-item {{ Route::currentRouteName() === 'admin.settings.edit' && request()->segment(3) === 'sms-settings' ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.edit', 'sms-settings') }}">SMS Settings</a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="sidebar-item mt-4 {{ Route::is('auth.profile') ? 'active' : '' }}">
                <a href="{{ route('auth.profile') }}" class="sidebar-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('auth.logout') }}" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</div>