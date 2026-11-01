@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-key text-primary"></i> Add Permission
                </h4>
                <p class="text-muted mb-0 small">Register a new system permission attribute</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('permission.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Permissions
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form class="needs-validation" method="post" action="{{ route('permission.post') }}" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="validationCustom01">Permission Identifier <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-key"></i></span>
                                    <input type="text" class="form-control" name="permission" id="validationCustom01" placeholder="e.g. create_order, edit_price" required>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a Permission Name.
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="validationCustom21">Type Identifier <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-tag"></i></span>
                                    <input type="text" class="form-control" name="type_id" id="validationCustom21" placeholder="e.g. 1" required>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a Type Id.
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('permission.list') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="ti ti-device-floppy me-1"></i> Save Permission
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
