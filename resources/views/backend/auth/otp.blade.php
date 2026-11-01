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
                <h2 class="text-white fw-bold mb-3">Two-Factor Authentication</h2>
                <p class="text-white-50 fs-6">Enter the one-time verification passcode (OTP) sent to your registered communication channel to complete sign in.</p>
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
                <h4 class="fw-bold mb-1 text-dark">Verify OTP 🔑</h4>
                <p class="text-muted small">Enter the 6-digit verification code</p>
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

            <form id="formAuthentication" action="{{ route('otp.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="otp" class="form-label fw-semibold">Enter OTP Code</label>
                    <div class="modern-input-group">
                        <span class="input-group-text"><i class="ti ti-shield-check"></i></span>
                        <input type="text" class="form-control text-center fs-4 fw-bold font-monospace" id="otp" name="otp" placeholder="· · · · · ·" maxlength="6" autofocus required />
                    </div>
                </div>

                <button class="btn btn-primary w-100 btn-auth-submit mb-3" type="submit">
                    <i class="ti ti-check me-2"></i> Verify & Sign In
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
