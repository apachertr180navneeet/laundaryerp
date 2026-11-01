@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-shield text-primary"></i> {{ !empty($role->id) ? 'Edit Role' : 'Create Role' }}
                </h4>
                <p class="text-muted mb-0 small">Define role name and assign permission access privileges</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('role.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Roles
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form class="needs-validation" method="post" action="{{ !empty($role->id) ? route('role.edit.post', ['id' => $role->id]) : route('role.post') }}" novalidate>
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-5">
                            <label class="form-label fw-semibold" for="roleName">Role Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="ti ti-badge"></i></span>
                                <input type="text" class="form-control" id="roleName" name="name" placeholder="e.g. Counter Staff, Accountant" required value="{{ !empty($role->name) ? $role->name : '' }}">
                            </div>
                            <span class="text-danger small mt-1 d-block">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </span>
                            <div class="invalid-feedback">
                                Please provide a Role Name.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="ti ti-lock-access text-primary"></i> Module Permissions
                        </h5>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" class="form-check-input" id="checkAll" role="switch">
                            <label class="form-check-label fw-semibold" for="checkAll">Select All Permissions</label>
                        </div>
                    </div>

                    <div class="row g-4">
                        @if (!empty($curruntopeningdata[0]))
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
                                    <i class="ti ti-briefcase"></i> Operations / Openings
                                </h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    @foreach ($curruntopeningdata as $value)
                                    <li class="form-check">
                                        <input {{ !empty($allpermissions) && in_array($value->id, $allpermissions) ? 'checked=checked' : '' }} type="checkbox" class="form-check-input models_checkbox" id="customCheck{{ $value->id }}" name="permissions[]" value="{{ $value->id }}">
                                        <label class="form-check-label" for="customCheck{{ $value->id }}">{{ $value->name }}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if (!empty($userdata[0]))
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
                                    <i class="ti ti-users"></i> Users Management
                                </h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    @foreach ($userdata as $value)
                                    <li class="form-check">
                                        <input {{ !empty($allpermissions) && in_array($value->id, $allpermissions) ? 'checked=checked' : '' }} type="checkbox" class="form-check-input models_checkbox" id="customCheck{{ $value->id }}" name="permissions[]" value="{{ $value->id }}">
                                        <label class="form-check-label" for="customCheck{{ $value->id }}">{{ $value->name }}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if (!empty($roledata[0]))
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
                                    <i class="ti ti-shield"></i> Roles & Permissions
                                </h6>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    @foreach ($roledata as $value)
                                    <li class="form-check">
                                        <input {{ !empty($allpermissions) && in_array($value->id, $allpermissions) ? 'checked=checked' : '' }} type="checkbox" class="form-check-input models_checkbox" id="customCheck{{ $value->id }}" name="permissions[]" value="{{ $value->id }}">
                                        <label class="form-check-label" for="customCheck{{ $value->id }}">{{ $value->name }}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 pt-4 border-top mt-4">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="ti ti-device-floppy me-1"></i> {{ !empty($role->id) ? 'Update Role' : 'Save Role' }}
                        </button>
                        <a href="{{ route('role.list') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extrascript')
<script>
    $('#checkAll').on('change', function() {
        $('.models_checkbox').prop('checked', this.checked);
    });
</script>
@endsection
