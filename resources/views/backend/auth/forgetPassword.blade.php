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
                <h2 class="text-white fw-bold mb-3">Forgot your password?</h2>
                <p class="text-white-50 fs-6">No worries! Enter your registered email address and we will provide the instructions or link to securely reset your credentials.</p>
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
                <h4 class="fw-bold mb-1 text-dark">Password Recovery 🔒</h4>
                <p class="text-muted small">Enter your email to receive recovery instructions</p>
            </div>

            @if(session('message'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-check fs-5"></i>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formAuthentication" action="{{ route('forget.password.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <div class="modern-input-group">
                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@company.com" value="{{ old('email') }}" required autofocus />
                    </div>
                </div>

                <button class="btn btn-primary w-100 btn-auth-submit mb-3" type="submit">
                    <i class="ti ti-mail-forward me-2"></i> Send Reset Link
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
