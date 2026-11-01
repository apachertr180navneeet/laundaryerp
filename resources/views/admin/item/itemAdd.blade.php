@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1F446E;">
                    <i class="ti ti-plus me-2"></i>Add Catalog Item
                </h4>
                <p class="text-muted mb-0 small">Map a new garment item with multiple categories, services, and rates.</p>
            </div>
            <div>
                <a href="{{ route('items') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <i class="ti ti-arrow-left ti-xs"></i>
                    <span>Back to Items</span>
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-2">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-tags text-primary"></i> Item & Service Configuration
                </h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="item-form" action="{{ route('store.item') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="item_name" class="form-label fw-semibold small text-muted">Item Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-tag text-muted"></i></span>
                                <input type="text" name="item_name" class="form-control" placeholder="e.g. Silk Shirt" id="item_name" value="{{ old('item_name') }}" required>
                            </div>
                            <span class="text-danger small mt-1 d-block" id="item_name_error">
                                @error('item_name') {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <div id="addcategory-container">
                        @php
                            $itemdetails = old('itemdetail', []);
                            if (empty($itemdetails)) {
                                $itemdetails = [1 => ['category' => '', 'service' => [null], 'price' => [null]]];
                            }
                        @endphp

                        @foreach ($itemdetails as $index => $detail)
                            <div class="border rounded-3 p-3 p-md-4 mb-3 bg-light addcategory" id="addcategory{{ $index }}">
                                <div class="row g-3 align-items-end mb-3">
                                    <div class="col-12 col-md-6">
                                        <label for="category{{ $index }}" class="form-label fw-semibold small text-muted">Target Category <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="ti ti-category text-muted"></i></span>
                                            <select class="form-select category-select" name="itemdetail[{{ $index }}][category]" id="category{{ $index }}" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categorys as $category)
                                                    <option value="{{ $category->name }}" {{ old("itemdetail.$index.category") == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger small mt-1 d-block" id="category{{ $index }}_error">
                                            @error("itemdetail.$index.category") {{ $message }} @enderror
                                        </span>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-end">
                                        @if ($loop->first)
                                            <button type="button" id="add-more" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                                                <i class="ti ti-plus ti-xs"></i> Add Another Category
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 remove-category" data-id="{{ $index }}">
                                                <i class="ti ti-trash ti-xs"></i> Remove Category
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-white p-3 rounded-2 border" id="addservice-container{{ $index }}">
                                    <h6 class="small fw-bold text-muted text-uppercase mb-3"><i class="ti ti-shirt me-1"></i> Associated Services & Prices</h6>
                                    @foreach ($detail['service'] as $sindex => $service)
                                        <div class="row g-3 align-items-end mb-2 addservice" id="addservice{{ $index }}_{{ $sindex + 1 }}">
                                            <div class="col-12 col-md-5">
                                                <label for="service{{ $index }}_{{ $sindex + 1 }}" class="form-label small text-muted">Service</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-light"><i class="ti ti-shirt text-muted"></i></span>
                                                    <select class="form-select service-select" name="itemdetail[{{ $index }}][service][]" id="service{{ $index }}_{{ $sindex + 1 }}" required>
                                                        <option value="">Select Service</option>
                                                        @foreach ($services as $serviceOption)
                                                            <option value="{{ $serviceOption->name }}" {{ old("itemdetail.$index.service.$sindex") == $serviceOption->name ? 'selected' : '' }}>{{ $serviceOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger small mt-1 d-block" id="service{{ $index }}_{{ $sindex + 1 }}_error">
                                                    @error("itemdetail.$index.service.$sindex") {{ $message }} @enderror
                                                </span>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="price{{ $index }}_{{ $sindex + 1 }}" class="form-label small text-muted">Unit Rate (₹)</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-light"><i class="ti ti-currency-rupee text-muted"></i></span>
                                                    <input type="text" class="form-control price-input" name="itemdetail[{{ $index }}][price][]" placeholder="0.00" id="price{{ $index }}_{{ $sindex + 1 }}" value="{{ old("itemdetail.$index.price.$sindex") }}" maxlength="5" required>
                                                </div>
                                                <span class="text-danger small mt-1 d-block" id="price{{ $index }}_{{ $sindex + 1 }}_error">
                                                    @error("itemdetail.$index.price.$sindex") {{ $message }} @enderror
                                                </span>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                @if ($sindex == 0 && $index == 1)
                                                    <button type="button" class="btn btn-outline-info btn-sm w-100 d-flex align-items-center justify-content-center gap-1 add-more-service" data-category-id="{{ $index }}">
                                                        <i class="ti ti-plus ti-xs"></i> Add Service
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-1 remove-service" data-id="{{ $index }}_{{ $sindex + 1 }}">
                                                        <i class="ti ti-trash ti-xs"></i> Remove
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light d-flex justify-content-end gap-2">
                <a href="{{ route('items') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="item-form" id="item-save" class="btn btn_1F446E_hp d-flex align-items-center gap-1">
                    <i class="ti ti-device-floppy ti-xs"></i>
                    <span>Save Item Configuration</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(function () {
        var categoryIndex = {{ count($itemdetails) }};
        var serviceIndices = @json(array_map(function($detail) { return count($detail['service']); }, $itemdetails));

        $(document).on('paste copy', '.price-input', e => e.preventDefault());

        $(document).on('input', '.price-input', function () {
            var value = $(this).val().replace(/[^0-9]/g, '').substring(0, 5);
            $(this).val(value === '0' ? '' : value);
        });

        $('#add-more').click(function () {
            categoryIndex++;
            serviceIndices[categoryIndex] = 1;
            $('#addcategory-container').append(createCategoryRow(categoryIndex));
            disableSelectedCategories();
        });

        $(document).on('click', '.add-more-service', function () {
            var categoryId = $(this).data('category-id');
            serviceIndices[categoryId]++;
            $('#addservice-container' + categoryId).append(createServiceRow(categoryId, serviceIndices[categoryId]));
            disableSelectedServices(categoryId);
        });

        $(document).on('click', '.remove-category', function () {
            var categoryId = $(this).data('id');
            $('#addcategory' + categoryId).remove();
            disableSelectedCategories();
        });

        $(document).on('click', '.remove-service', function () {
            var id = $(this).data('id');
            $('#addservice' + id).remove();
            var categoryId = id.split('_')[0];
            disableSelectedServices(categoryId);
        });

        $(document).on('change', '.category-select', function () {
            disableSelectedCategories();
        });

        $(document).on('change', '.service-select', function () {
            var categoryId = $(this).closest('.addcategory').attr('id').replace('addcategory', '');
            disableSelectedServices(categoryId);
        });

        function disableSelectedCategories() {
            var selectedCategories = [];
            $('.category-select').each(function () {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    selectedCategories.push(selectedValue);
                }
            });

            $('.category-select').each(function () {
                var currentSelect = $(this);
                currentSelect.find('option').each(function () {
                    var optionValue = $(this).val();
                    if (selectedCategories.includes(optionValue) && optionValue !== currentSelect.val()) {
                        $(this).attr('disabled', true);
                    } else {
                        $(this).attr('disabled', false);
                    }
                });
            });
        }

        function disableSelectedServices(categoryId) {
            var selectedServices = [];
            $('#addcategory' + categoryId + ' .service-select').each(function () {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    selectedServices.push(selectedValue);
                }
            });

            $('#addcategory' + categoryId + ' .service-select').each(function () {
                var currentSelect = $(this);
                currentSelect.find('option').each(function () {
                    var optionValue = $(this).val();
                    if (selectedServices.includes(optionValue) && optionValue !== currentSelect.val()) {
                        $(this).attr('disabled', true);
                    } else {
                        $(this).attr('disabled', false);
                    }
                });
            });
        }

        $('#item-form').submit(function (e) {
            var isValid = true;
            $('#item_name').each(function () {
                if (!$(this).val()) {
                    $('#' + $(this).attr('id') + '_error').text('This field is required.');
                    isValid = false;
                } else {
                    $('#' + $(this).attr('id') + '_error').text('');
                }
            });

            $('.category-select, .service-select').each(function () {
                if (!$(this).val()) {
                    $('#' + $(this).attr('id') + '_error').text('This field is required.');
                    isValid = false;
                } else {
                    $('#' + $(this).attr('id') + '_error').text('');
                }
            });

            $('.price-input').each(function () {
                if (!$(this).val() || $(this).val() <= 0) {
                    $('#' + $(this).attr('id') + '_error').text('Please enter a valid price.');
                    isValid = false;
                } else {
                    $('#' + $(this).attr('id') + '_error').text('');
                }
            });

            if (!isValid) e.preventDefault();
        });

        function createCategoryRow(index) {
            return `
                <div class="border rounded-3 p-3 p-md-4 mb-3 bg-light addcategory" id="addcategory${index}">
                    <div class="row g-3 align-items-end mb-3">
                        <div class="col-12 col-md-6">
                            <label for="category${index}" class="form-label fw-semibold small text-muted">Target Category <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="ti ti-category text-muted"></i></span>
                                <select class="form-select category-select" name="itemdetail[${index}][category]" id="category${index}" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categorys as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger small mt-1 d-block" id="category${index}_error"></span>
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 remove-category" data-id="${index}">
                                <i class="ti ti-trash ti-xs"></i> Remove Category
                            </button>
                        </div>
                    </div>
                    <div class="bg-white p-3 rounded-2 border" id="addservice-container${index}">
                        <h6 class="small fw-bold text-muted text-uppercase mb-3"><i class="ti ti-shirt me-1"></i> Associated Services & Prices</h6>
                        <div class="row g-3 align-items-end mb-2 addservice" id="addservice${index}_1">
                            <div class="col-12 col-md-5">
                                <label for="service${index}_1" class="form-label small text-muted">Service</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light"><i class="ti ti-shirt text-muted"></i></span>
                                    <select class="form-select service-select" name="itemdetail[${index}][service][]" id="service${index}_1" required>
                                        <option value="">Select Service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->name }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger small mt-1 d-block" id="service${index}_1_error"></span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="price${index}_1" class="form-label small text-muted">Unit Rate (₹)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light"><i class="ti ti-currency-rupee text-muted"></i></span>
                                    <input type="text" class="form-control price-input" name="itemdetail[${index}][price][]" placeholder="0.00" id="price${index}_1" maxlength="5" required>
                                </div>
                                <span class="text-danger small mt-1 d-block" id="price${index}_1_error"></span>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-outline-info btn-sm w-100 d-flex align-items-center justify-content-center gap-1 add-more-service" data-category-id="${index}">
                                    <i class="ti ti-plus ti-xs"></i> Add Service
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function createServiceRow(categoryId, serviceId) {
            return `
                <div class="row g-3 align-items-end mb-2 addservice" id="addservice${categoryId}_${serviceId}">
                    <div class="col-12 col-md-5">
                        <label for="service${categoryId}_${serviceId}" class="form-label small text-muted">Service</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="ti ti-shirt text-muted"></i></span>
                            <select class="form-select service-select" name="itemdetail[${categoryId}][service][]" id="service${categoryId}_${serviceId}" required>
                                <option value="">Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->name }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger small mt-1 d-block" id="service${categoryId}_${serviceId}_error"></span>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="price${categoryId}_${serviceId}" class="form-label small text-muted">Unit Rate (₹)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="ti ti-currency-rupee text-muted"></i></span>
                            <input type="text" class="form-control price-input" name="itemdetail[${categoryId}][price][]" placeholder="0.00" id="price${categoryId}_${serviceId}" maxlength="5" required>
                        </div>
                        <span class="text-danger small mt-1 d-block" id="price${categoryId}_${serviceId}_error"></span>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-1 remove-service" data-id="${categoryId}_${serviceId}">
                            <i class="ti ti-trash ti-xs"></i> Remove
                        </button>
                    </div>
                </div>`;
        }
    });
</script>
@endsection
