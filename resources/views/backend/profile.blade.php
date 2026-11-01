@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1F446E;">
                    <i class="ti ti-user me-2"></i>My Profile
                </h4>
                <p class="text-muted mb-0 small">Manage your administrative profile and account details.</p>
            </div>
            <div>
                <a href="{{ route('edit.profile', ['id' => Auth::user()->id]) }}" class="btn btn_1F446E_hp btn-sm d-flex align-items-center gap-1 shadow-sm">
                    <i class="ti ti-pencil ti-xs"></i>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            <!-- Left: Profile Summary Card -->
            <div class="col-12 col-md-5 col-lg-4">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="avatar avatar-xl rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px; display: flex; align-items: center; justify-content: center; background: rgba(31, 68, 110, 0.1); color: #1F446E;">
                        @if(Auth::user()->image && file_exists(public_path('images/'.Auth::user()->image)))
                            <img src="{{ asset('images/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle h-100 w-100 object-fit-cover" />
                        @else
                            <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <div>
                        <span class="badge bg-label-primary px-3 py-1 rounded-pill fw-semibold">
                            System Administrator
                        </span>
                    </div>

                    <div class="border-top mt-4 pt-3 text-start">
                        <small class="text-muted text-uppercase fw-semibold d-block mb-2">Account Actions</small>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('edit.profile', ['id' => Auth::user()->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                                <i class="ti ti-user-edit"></i> Edit Account
                            </a>
                            <a href="{{ route('change.password') }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center gap-2">
                                <i class="ti ti-key"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Details Card -->
            <div class="col-12 col-md-7 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header pb-2">
                        <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                            <i class="ti ti-id text-primary"></i> Personal & Role Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="small text-muted fw-semibold d-block">Full Name</label>
                                <span class="fw-medium text-dark fs-6">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="small text-muted fw-semibold d-block">Email Address</label>
                                <span class="fw-medium text-dark fs-6">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="small text-muted fw-semibold d-block">Registered Phone</label>
                                <span class="fw-medium text-dark fs-6">{{ Auth::user()->mobile ?? 'Not provided' }}</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="small text-muted fw-semibold d-block">Account Status</label>
                                <span class="badge bg-label-success rounded-pill px-3 py-1 fw-semibold">Active</span>
                            </div>
                        </div>

                        <div class="border-top mt-4 pt-3">
                            <h6 class="fw-semibold text-dark mb-2"><i class="ti ti-shield-lock me-1 text-primary"></i> Security & Permissions</h6>
                            <p class="text-muted small mb-0">You have full administrative privileges to create orders, settle payments, configure garment catalog rates, and export financial reports.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
