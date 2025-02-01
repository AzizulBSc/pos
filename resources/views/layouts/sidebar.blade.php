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
            <li class="sidebar-item {{ Route::is('admin.cart.index') ? 'active' : '' }}">
                <a href="{{ route('admin.cart.index') }}" class="sidebar-link">
                    <i class="bi bi-cart"></i>
                    <span>POS</span>
                </a>
            </li>
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

            @can('view_brands')
            <li class="sidebar-item has-sub {{ Route::is('admin.brands.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Brand</span>
                </a>
                <ul class="submenu {{ Route::is('admin.brands.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_brands')
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
            @can('view_units')
            <li class="sidebar-item has-sub {{ Route::is('admin.units.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Unit</span>
                </a>
                <ul class="submenu {{ Route::is('admin.units.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_units')
                    <li class="submenu-item {{ Route::is('admin.units.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.units.index') }}">Unit List</a>
                    </li>
                    @endcan
                    @can('create_unit')
                    <li class="submenu-item {{ Route::is('admin.units.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.units.create') }}">Add Unit</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_products')
            <li class="sidebar-item has-sub {{ Route::is('admin.products.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Product</span>
                </a>
                <ul class="submenu {{ Route::is('admin.products.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_products')
                    <li class="submenu-item {{ Route::is('admin.products.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}">Product List</a>
                    </li>
                    @endcan
                    @can('create_product')
                    <li class="submenu-item {{ Route::is('admin.products.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.create') }}">Add Product</a>
                    </li>
                    @endcan
                    @can('view_products')
                    <li class="submenu-item {{ Route::is('admin.products.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index', ['q' => 'low_stocked']) }}">Low Stocked</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_purchases')
            <li class="sidebar-item has-sub {{ Route::is('admin.purchases.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Purchase</span>
                </a>
                <ul class="submenu {{ Route::is('admin.purchases.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_purchases')
                    <li class="submenu-item {{ Route::is('admin.purchases.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchases.index') }}">Purchase List</a>
                    </li>
                    @endcan
                    @can('create_purchase')
                    <li class="submenu-item {{ Route::is('admin.purchases.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchases.create') }}">Add Purchase</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_customers')
            <li class="sidebar-item has-sub {{ Route::is('admin.customers.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Customer</span>
                </a>
                <ul class="submenu {{ Route::is('admin.customers.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_customers')
                    <li class="submenu-item {{ Route::is('admin.customers.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.customers.index') }}">Customer List</a>
                    </li>
                    @endcan
                    @can('create_customer')
                    <li class="submenu-item {{ Route::is('admin.customers.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.customers.create') }}">Add Customer</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_suppliers')
            <li class="sidebar-item has-sub {{ Route::is('admin.suppliers.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Supplier</span>
                </a>
                <ul class="submenu {{ Route::is('admin.suppliers.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_suppliers')
                    <li class="submenu-item {{ Route::is('admin.suppliers.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.suppliers.index') }}">Supplier List</a>
                    </li>
                    @endcan
                    @can('create_supplier')
                    <li class="submenu-item {{ Route::is('admin.suppliers.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.suppliers.create') }}">Add Supplier</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_sales')
            <li class="sidebar-item has-sub {{ Route::is('admin.sales.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Sale</span>
                </a>
                <ul class="submenu {{ Route::is('admin.sales.*') ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_sales')
                    <li class="submenu-item {{ Route::is('admin.sales.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.sales.index') }}">Sale List</a>
                    </li>
                    @endcan
                    @can('create_sale')
                    <li class="submenu-item {{ Route::is('admin.sales.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.cart.index') }}">Add Sale</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('view_sales')
            <li class="sidebar-item has-sub {{ Route::is(['admin.sale.summery','admin.sale.report','admin.inventory.report']) ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-link toggle-submenu">
                    <i class="bi bi-people"></i>
                    <span>Reports</span>
                </a>
                <ul class="submenu {{ Route::is(['admin.sale.summery','admin.sale.report','admin.inventory.report']) ? 'submenu-open' : 'submenu-close' }}">
                    @can('view_sales')
                    <li class="submenu-item {{ Route::is('admin.sale.summery') ? 'active' : '' }}">
                        <a href="{{ route('admin.sale.summery') }}">Summery</a>
                    </li>
                    @endcan
                    @can('view_sales')
                    <li class="submenu-item {{ Route::is('admin.sale.report') ? 'active' : '' }}">
                        <a href="{{ route('admin.sale.report') }}">Sales</a>
                    </li>
                    @endcan
                    @can('view_sales')
                    <li class="submenu-item {{ Route::is('admin.inventory.report') ? 'active' : '' }}">
                        <a href="{{ route('admin.inventory.report') }}">Inventory</a>
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