@extends('backend.layouts.auth_app')
@section('content')
<div class="auth-page-wrapper">
    <div class="row g-0 min-vh-100">
        <!-- Left Column: Modern Hero Branding Panel (Visible on lg and up) -->
        <div class="col-lg-7 col-xl-8 d-none d-lg-flex auth-brand-panel flex-column justify-content-between p-5 text-white">
            <!-- Brand Header -->
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('theam/Images/white_logo.png') }}" alt="WashFlow ERP" style="height: 46px; width: auto; object-fit: contain;">
                <span class="badge rounded-pill px-3 py-1 small fw-semibold" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                    Enterprise ERP v2.0
                </span>
            </div>

            <!-- Central Content -->
            <div class="my-auto py-5" style="max-width: 660px; z-index: 1;">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-4 small" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="ti ti-sparkles text-warning"></i>
                    <span>Next-Generation Laundry & Dry Cleaning Management</span>
                </div>
                <h1 class="display-6 fw-bold text-white mb-3" style="line-height: 1.25; letter-spacing: -0.02em;">
                    Smart Garment Operations, Automated from Intake to Delivery.
                </h1>
                <p class="fs-6 mb-5 text-white-50" style="line-height: 1.7; max-width: 580px;">
                    Fast counter POS, barcode tagging, customizable pricing catalog, instant thermal receipting, and real-time revenue analytics.
                </p>

                <!-- Value Proposition Cards -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 backdrop-blur h-100" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                            <div class="d-inline-flex p-2 rounded-2 mb-2" style="background: rgba(255, 193, 7, 0.2);">
                                <i class="ti ti-bolt text-warning fs-4"></i>
                            </div>
                            <h6 class="text-white fw-semibold mb-1">Fast POS Intake</h6>
                            <p class="small text-white-50 mb-0">Rapid counter booking with service & express tags.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 backdrop-blur h-100" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                            <div class="d-inline-flex p-2 rounded-2 mb-2" style="background: rgba(13, 202, 240, 0.2);">
                                <i class="ti ti-receipt text-info fs-4"></i>
                            </div>
                            <h6 class="text-white fw-semibold mb-1">Instant Invoicing</h6>
                            <p class="small text-white-50 mb-0">Thermal receipts, tax computation & tags.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 backdrop-blur h-100" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                            <div class="d-inline-flex p-2 rounded-2 mb-2" style="background: rgba(25, 135, 84, 0.2);">
                                <i class="ti ti-chart-line text-success fs-4"></i>
                            </div>
                            <h6 class="text-white fw-semibold mb-1">Live Tracking</h6>
                            <p class="small text-white-50 mb-0">Order status, revenue, payments and delivery.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Footer -->
            <div class="d-flex align-items-center justify-content-between text-white-50 small pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.15) !important;">
                <span>&copy; {{ date('Y') }} WashFlow ERP. All rights reserved.</span>
                <span class="d-flex align-items-center gap-1">
                    <i class="ti ti-shield-check text-success"></i> Encrypted Administrative Access
                </span>
            </div>
        </div>

        <!-- Right Column: Clean, Modern Sign-In Card -->
        <div class="col-12 col-lg-5 col-xl-4 d-flex align-items-center justify-content-center auth-form-panel">
            <div class="auth-form-box">
                <!-- Mobile Brand Header -->
                <div class="d-lg-none text-center mb-4">
                    <img src="{{ asset('theam/Images/logo.png') }}" alt="WashFlow ERP" style="height: 48px; width: auto;" class="mb-2">
                </div>

                <!-- Form Header -->
                <div class="mb-4">
                    <span class="badge bg-label-primary px-3 py-1 rounded-pill small fw-semibold mb-2">Staff & Admin Access</span>
                    <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em; color: #1F446E;">Sign In</h3>
                    <p class="text-muted small mb-0">Enter your administrative credentials to manage operations.</p>
                </div>

                <!-- Alerts -->
                @if (Session::has('error'))
                    <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                        <i class="ti ti-alert-circle"></i>
                        <span>{{ Session::get('error') }}</span>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                        <i class="ti ti-check"></i>
                        <span>{{ Session::get('success') }}</span>
                    </div>
                @endif

                <!-- Authentication Form -->
                <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-dark">Email or Username</label>
                        <div class="input-group modern-input-group">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="admin@laundry.com" value="{{ old('email') }}" required autofocus />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="form-label small fw-semibold text-dark mb-0" for="password">Password</label>
                            <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary fw-medium">
                                Forgot password?
                            </a>
                        </div>
                        <div class="input-group modern-input-group">
                            <span class="input-group-text"><i class="ti ti-lock"></i></span>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="••••••••••••" required />
                            <span class="input-group-text password-toggle cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                        @if ($errors->any())
                            <small class="text-danger d-block mt-1">{{ $errors->first() }}</small>
                        @endif
                    </div>

                    <!-- Remember Option -->
                    <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" style="cursor: pointer;">
                            <label class="form-check-label small text-muted cursor-pointer" for="remember-me">
                                Keep me signed in
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn_1F446E_hp btn-auth-submit w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm rounded-3" type="submit">
                        <span>Sign In to Dashboard</span>
                        <i class="ti ti-arrow-right"></i>
                    </button>
                </form>

                <!-- Help / Support Footer -->
                <div class="mt-4 pt-3 text-center border-top">
                    <p class="text-muted small mb-0">
                        Need assistance accessing your account?<br>
                        <span class="text-dark fw-medium">Contact your System Administrator</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        const toggleBtn = document.querySelector(".password-toggle");

        if (passwordInput && toggleBtn) {
            toggleBtn.addEventListener("click", function() {
                const isPassword = passwordInput.getAttribute("type") === "password";
                passwordInput.setAttribute("type", isPassword ? "text" : "password");
                const icon = toggleBtn.querySelector("i");
                if (icon) {
                    icon.classList.toggle("ti-eye-off", !isPassword);
                    icon.classList.toggle("ti-eye", isPassword);
                }
            });
        }
    });
</script>
@endsection
