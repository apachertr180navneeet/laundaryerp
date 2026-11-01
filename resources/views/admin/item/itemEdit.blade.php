@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1F446E;">
                    <i class="ti ti-pencil me-2"></i>Edit Item Pricing
                </h4>
                <p class="text-muted mb-0 small">Update garment unit price and service configuration.</p>
            </div>
            <div>
                <a href="{{ route('items') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <i class="ti ti-arrow-left ti-xs"></i>
                    <span>Back to Items</span>
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header pb-2">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-tags text-primary"></i> Item Details
                </h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="item-form" action="{{ route('update.item') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $Intemdetails->id }}">
                    <input type="hidden" name="item_id" value="{{ $Intemdetails->item_id }}">

                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="item_name" class="form-label fw-semibold small text-muted">Item Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-tags text-muted"></i></span>
                                <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name" id="item_name" value="{{ $Intemdetails->item_name }}" required>
                            </div>
                            @error('item_name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="item_category" class="form-label fw-semibold small text-muted">Category (Mapped)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-category text-muted"></i></span>
                                <input type="text" name="item_category" class="form-control bg-light" id="item_category" value="{{ $Intemdetails->category }}" readonly>
                            </div>
                            @error('item_category')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="item_service" class="form-label fw-semibold small text-muted">Service (Mapped)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-shirt text-muted"></i></span>
                                <input type="text" name="item_service" class="form-control bg-light" id="item_service" value="{{ $Intemdetails->service }}" readonly>
                            </div>
                            @error('item_service')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="item_price" class="form-label fw-semibold small text-muted">Unit Price (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-currency-rupee text-muted"></i></span>
                                <input type="number" step="0.01" name="item_price" class="form-control" placeholder="0.00" id="item_price" value="{{ $Intemdetails->price }}" required>
                            </div>
                            @error('item_price')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light d-flex justify-content-end gap-2">
                <a href="{{ route('items') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="item-form" id="item-save" class="btn btn_1F446E_hp d-flex align-items-center gap-1">
                    <i class="ti ti-device-floppy ti-xs"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
