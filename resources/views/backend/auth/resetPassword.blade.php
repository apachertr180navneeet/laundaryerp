@extends('backend.layouts.auth_app')

@section('content')
<div class="auth-page-wrapper">
    <!-- Left Hero/Brand Panel (Desktop) -->
    <div class="auth-brand-panel d-none d-lg-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-3 mb-4">
                <img src="{{ asset('theam/Images/logo.png') }}" alt="WashFlow ERP" class="bg-white rounded p-2 shadow-sm" style="height: 52px; width: auto;" />
                <div>
                    <h3 class="text-white fw-bold mb-0">WashFlow ERP</h3>
                    <small class="text-white-50">Smart Laundry & Dry Cleaning Management</small>
                </div>
            </div>
            <div class="mt-5">
                <h2 class="text-white fw-bold mb-3">Reset Your Password</h2>
                <p class="text-white-50 fs-6">Set a strong and secure new password to regain access to your administrator and operations portal.</p>
            </div>
        </div>

        <div class="text-white-50 small">
            &copy; 2026 WashFlow ERP · Safe & Encrypted Access
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="auth-form-panel">
        <div class="auth-form-box">
            <!-- Mobile Brand Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('theam/Images/logo.png') }}" alt="WashFlow ERP" class="auth-mobile-logo" />
                <h4 class="fw-bold mb-1 text-dark">Reset Password 🔒</h4>
                <p class="text-muted small">Choose a new password for your account</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email_address" class="form-label fw-semibold">E-Mail Address</label>
                    <div class="modern-input-group">
                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                        <input type="email" id="email_address" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">New Password</label>
                    <div class="modern-input-group">
                        <span class="input-group-text"><i class="ti ti-lock"></i></span>
                        <input type="password" id="password" class="form-control" name="password" required placeholder="············">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                    <div class="modern-input-group">
                        <span class="input-group-text"><i class="ti ti-check"></i></span>
                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required placeholder="············">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-auth-submit mb-3">
                    <i class="ti ti-device-floppy me-2"></i> Update Password
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="d-inline-flex align-items-center text-primary fw-semibold small">
                        <i class="ti ti-chevron-left me-1"></i> Back to Sign In
                    </a>
                </div>
            </form>

            <div class="text-center text-muted small mt-4 pt-3 border-top">
                WashFlow ERP &copy; 2026 · All Rights Reserved
            </div>
        </div>
    </div>
</div>
@endsection
