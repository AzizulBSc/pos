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
