@if (!Auth::user())
    @php
        $errorMessage = 'Please contact the superadmin for access.';
        return redirect()->route('login')->withErrors([$errorMessage]);
    @endphp
@else
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme bg_1F446E_hp sidebar_section_hp">
    <div class="app-brand demo" style="height: 75px; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;">
        <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center gap-2">
            <img src="{{ asset('theam/Images/white_logo.png') }}" alt="WashFlow ERP" style="max-height: 44px; width: auto; object-fit: contain;">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none text-white p-2">
            <i class="ti ti-x ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-2 mt-0">
        <!-- Main Section -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Overview</span>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-dashboard"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('orders.analitices') ? 'active' : '' }}">
            <a href="{{ route('orders.analitices') }}" class="menu-link">
                <i class="menu-icon ti ti-chart-pie-2"></i>
                <div data-i18n="Analytics">Analytics</div>
            </a>
        </li>

        <!-- Directory & Catalog -->
        <li class="menu-header small text-uppercase mt-2">
            <span class="menu-header-text">Catalog & Clients</span>
        </li>
        <li class="menu-item {{ request()->routeIs('clientpage*') ? 'active' : '' }}">
            <a href="{{ route('clientpage') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('categories*') ? 'active' : '' }}">
            <a href="{{ route('categories') }}" class="menu-link">
                <i class="menu-icon ti ti-category"></i>
                <div data-i18n="Categories">Categories</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('services*') ? 'active' : '' }}">
            <a href="{{ route('services') }}" class="menu-link">
                <i class="menu-icon ti ti-shirt"></i>
                <div data-i18n="Services">Services</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('items*') ? 'active' : '' }}">
            <a href="{{ route('items') }}" class="menu-link">
                <i class="menu-icon ti ti-tags"></i>
                <div data-i18n="Item">Items</div>
            </a>
        </li>

        <!-- Orders & Billing -->
        <li class="menu-header small text-uppercase mt-2">
            <span class="menu-header-text">Orders & Billing</span>
        </li>
        <li class="menu-item {{ (request()->routeIs('addOrder') || request()->routeIs('viewOrder') || request()->routeIs('order.*') || request()->is('admin/show-order*')) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-package"></i>
                <div data-i18n="Orders">Orders</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('addOrder') ? 'active' : '' }}">
                    <a href="{{ route('addOrder') }}" class="menu-link">
                        <i class="ti ti-plus ti-xs me-2"></i>
                        <div data-i18n="Add Order">New Order</div>
                    </a>
                </li>
                <li class="menu-item {{ (request()->routeIs('viewOrder') || request()->routeIs('order.*') || request()->is('admin/show-order*')) ? 'active' : '' }}">
                    <a href="{{ route('viewOrder') }}" class="menu-link">
                        <i class="ti ti-list ti-xs me-2"></i>
                        <div data-i18n="View Orders">All Orders</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->routeIs('payment*') ? 'active' : '' }}">
            <a href="{{ route('payment') }}" class="menu-link">
                <i class="ti ti-credit-card menu-icon"></i>
                <div data-i18n="Payment">Payments</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('invoice*') ? 'active' : '' }}">
            <a href="{{ route('invoice') }}" class="menu-link">
                <i class="ti ti-receipt menu-icon"></i>
                <div data-i18n="Invoice">Invoices</div>
            </a>
        </li>
    </ul>
</aside>


<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme bg_1F446E_hp"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 text-white sidebar_toggle_btn_area">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm text-white" ></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
        <div class="navbar-nav align-items-center me-auto d-none d-md-flex">
            <span class="text-white-50 small me-2"><i class="ti ti-sparkles text-warning me-1"></i> WashFlow ERP</span>
            <span class="badge bg-white text-primary rounded-pill px-2 py-1 small fw-semibold">Live</span>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2">
            <!-- Quick New Order Shortcut -->
            <li class="nav-item me-1 me-sm-2">
                <a href="{{ route('addOrder') }}" class="btn btn-sm btn-light text-primary fw-semibold shadow-sm d-flex align-items-center gap-1 px-2 px-sm-3" style="border-radius: 20px;" title="New Order">
                    <i class="ti ti-plus ti-xs"></i>
                    <span class="d-none d-sm-inline">New Order</span>
                </a>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center gap-2" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if(Auth::user()->image && file_exists(public_path('images/'.Auth::user()->image)))
                            <img src="{{ asset('images/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="h-auto rounded-circle" />
                        @else
                            <div class="avatar-initial rounded-circle bg-white text-primary fw-bold" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="d-none d-lg-block text-start">
                        <span class="fw-semibold text-white d-block lh-1 small">{{ Auth::user()->name }}</span>
                        <small class="text-white-50" style="font-size: 11px;">Admin</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2" style="min-width: 220px; border-radius: 12px;">
                    <li class="px-3 py-2 border-bottom mb-1">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <div class="avatar-initial rounded-circle bg-label-primary fw-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <span class="fw-semibold text-dark d-block text-truncate">{{ Auth::user()->name }}</span>
                                <small class="text-muted d-block text-truncate">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('myProfile') }}">
                            <i class="ti ti-user me-2 text-primary"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('change.password') }}">
                            <i class="ti ti-key me-2 text-warning"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}">
                            <i class="ti ti-logout me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
@endif
