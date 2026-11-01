@extends('backend.layouts.auth_app')
@section('content')
<!-- Content -->
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4 login_page_section_hp" style="max-width: 440px; margin: 0 auto;">
            <!-- Login Card -->
            <div class="card shadow-lg border-0" style="border-radius: 16px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">
                <div class="card-body p-4 p-sm-5">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-3">
                        <a href="javascript:void(0);" class="app-brand-link gap-2">
                            <img src="{{ asset('theam/Images/logo.png') }}" style="max-height: 52px; width: auto; object-fit: contain;">
                        </a>
                    </div>
                    <!-- /Logo -->

                    <div class="text-center mb-4">
                        <h4 class="mb-1 fw-bold" style="color: #1F446E;">WashFlow ERP</h4>
                        <p class="text-muted small mb-0">Sign in to manage laundry operations, orders & billing</p>
                    </div>

                    @if (Session::has('error'))
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3" role="alert">
                            <i class="ti ti-alert-circle"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3" role="alert">
                            <i class="ti ti-check"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-muted">Email or Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="email" name="email"
                                    placeholder="Enter your email or username" value="{{ old('email') }}" required autofocus />
                            </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label small fw-semibold text-muted mb-0" for="password">Password</label>
                                <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock text-muted"></i></span>
                                <input type="password" id="password" class="form-control border-start-0 ps-0" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer bg-light"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @if ($errors->any())
                                <small class="text-danger d-block mt-1">{{ $errors->first() }}</small>
                            @endif
                        </div>

                        <div class="mt-4 mb-2">
                            <button class="btn w-100 btn_1F446E_hp py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow" type="submit">
                                <i class="ti ti-login"></i>
                                <span>Sign In</span>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3 pt-2 border-top">
                        <small class="text-muted">WashFlow ERP &copy; {{ date('Y') }} &bull; All Rights Reserved</small>
                    </div>

                </div>
            </div>
            <!-- /Login Card -->
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        if (passwordInput) {
            const toggleWrapper = passwordInput.parentElement.querySelector(".input-group-text.cursor-pointer");
            if (toggleWrapper) {
                const eyeIcon = toggleWrapper.querySelector("i");
                toggleWrapper.addEventListener("click", function() {
                    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                    passwordInput.setAttribute("type", type);
                    if (eyeIcon) {
                        eyeIcon.classList.toggle("ti-eye-off");
                        eyeIcon.classList.toggle("ti-eye");
                    }
                });
            }
        }
    });
</script>
