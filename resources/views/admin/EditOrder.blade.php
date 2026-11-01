@extends('backend.layouts.app')
@section('content')
<style>
    /* WashFlow Modern Order POS Styling */
    .pos-card {
        background: #ffffff;
        border: 1px solid #e6ebf1;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(31, 68, 110, 0.04);
        transition: all 0.2s ease-in-out;
    }
    .pos-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(31, 68, 110, 0.08);
    }
    .catalog-item-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    .catalog-item-card:hover {
        border-color: #1F446E;
        box-shadow: 0 3px 10px rgba(31, 68, 110, 0.08);
        transform: translateY(-1px);
    }
    .badge-chip {
        cursor: pointer;
        font-size: 0.78rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.15s ease;
        display: inline-block;
        border: 1px solid transparent;
        user-select: none;
    }
    .badge-chip.inactive {
        background-color: #f1f5f9;
        color: #475569;
        border-color: #e2e8f0;
    }
    .badge-chip.inactive:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }
    .badge-chip.active {
        background-color: #1F446E !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(31, 68, 110, 0.25);
    }

    /* Service Pills & Grid */
    .service-chip {
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        transition: all 0.15s ease;
        user-select: none;
    }
    .service-chip:hover {
        border-color: #94a3b8;
        background: #f1f5f9;
    }
    .service-chip.selected {
        background: #1F446E;
        border-color: #1F446E;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(31, 68, 110, 0.25);
    }
    .service-chip.selected .service-price-tag {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }
    .service-price-tag {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 4px;
        background: #e2e8f0;
        color: #334155;
    }

    /* Cart Table & Elements */
    .cart-table-wrapper {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow-x: auto;
        background: #ffffff;
    }
    .cart-table {
        margin-bottom: 0;
        font-size: 0.875rem;
    }
    .cart-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0;
        padding: 10px 12px;
        white-space: nowrap;
    }
    .cart-table td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .cart-empty-box {
        padding: 32px 16px;
        text-align: center;
        color: #94a3b8;
        background: #fbfcfd;
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
    }
    .cart-empty-box i {
        font-size: 2.5rem;
        color: #cbd5e1;
        margin-bottom: 8px;
        display: block;
    }

    /* Summary Card */
    .order-summary-card {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
    }

    /* Quantity Steppers */
    .stepper-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-weight: 600;
        transition: all 0.15s ease;
    }
    .stepper-btn:hover:not(:disabled) {
        background: #1F446E;
        color: #ffffff;
        border-color: #1F446E;
    }
    .stepper-input {
        width: 60px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 4px;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .pos-sticky-summary {
            position: static !important;
        }
        .catalog-container {
            max-height: none !important;
        }
    }
    @media (min-width: 992px) {
        .catalog-container {
            max-height: 85vh;
            overflow-y: auto;
            padding-right: 6px;
        }
    }
</style>

<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-shopping-cart-plus text-primary"></i> Create New Order
                </h4>
                <p class="text-muted mb-0 small">Counter POS intake & garment service selector</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('viewOrder') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Orders
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="ti ti-alert-circle fs-4 me-2"></i>
                    <div>
                        <strong class="d-block">Please correct the following errors:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('add.order') }}" method="POST" id="addOrderFormValidation" enctype="multipart/form-data">
            @csrf

            <!-- Hidden inputs dynamically populated by OrderPOS.renderCart() -->
            <div id="hiddenInputsContainer"></div>

            <input type="hidden" id="booking_date" name="booking_date" value="{{ $currentdate }}" />
            <input type="hidden" id="booking_time" name="booking_time" value="{{ $currenttime }}" />
            <input type="hidden" id="gross_total" name="gross_total" value="0.00" />
            <input type="hidden" id="total_qty" name="total_qty" value="0" />

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: Customer, Cart & Pricing ================= -->
                <div class="col-lg-6 col-xl-6">
                    <!-- Customer Information Card -->
                    <div class="card pos-card mb-4">
                        <div class="card-header border-bottom py-3 d-flex align-items-center justify-content-between bg-light">
                            <h6 class="mb-0 fw-semibold text-dark">
                                <i class="ti ti-user me-1 text-primary"></i> Customer Details
                            </h6>
                            <span class="badge bg-label-primary rounded-pill small" id="customerStatusBadge">Counter Walk-in</span>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label for="number" class="form-label fw-semibold small">
                                        Mobile Number <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="ti ti-phone"></i></span>
                                        <input type="tel" id="number" name="client_num" class="form-control"
                                            placeholder="10-digit mobile" maxlength="10" required
                                            value="{{ old('client_num', $order->mobile ?? '') }}" />
                                    </div>
                                    <div id="clientLookupFeedback" class="small mt-1 text-muted"></div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="client_name" class="form-label fw-semibold small">
                                        Customer Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="ti ti-user"></i></span>
                                        <input type="text" id="client_name" name="client_name" class="form-control"
                                            placeholder="Full name" maxlength="30" required
                                            value="{{ old('client_name', $order->name ?? '') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart / Added Items Card -->
                    <div class="card pos-card mb-4">
                        <div class="card-header border-bottom py-3 d-flex align-items-center justify-content-between bg-light">
                            <h6 class="mb-0 fw-semibold text-dark">
                                <i class="ti ti-basket me-1 text-primary"></i> Order Items / Garments
                            </h6>
                            <span class="badge bg-primary rounded-pill" id="cartItemCountBadge">0 items</span>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <!-- Empty Cart Placeholder -->
                            <div id="cartEmptyState" class="cart-empty-box">
                                <i class="ti ti-shopping-cart-x"></i>
                                <h6 class="fw-semibold text-dark mb-1">No garments added yet</h6>
                                <p class="small text-muted mb-0">Select garments from the catalog on the right to build this order.</p>
                            </div>

                            <!-- Cart Items Container -->
                            <div id="cartItemsContainer" style="display: none;">
                                <div class="cart-table-wrapper">
                                    <table class="table cart-table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Garment / Service</th>
                                                <th class="text-center" style="width: 120px;">Qty / Wt</th>
                                                <th class="text-end" style="width: 90px;">Rate</th>
                                                <th class="text-end" style="width: 100px;">Total</th>
                                                <th class="text-center" style="width: 45px;"><i class="ti ti-trash text-muted"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartTableBody">
                                            <!-- Dynamically rendered rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scheduling & Order Summary Card -->
                    <div class="card pos-card mb-4">
                        <div class="card-header border-bottom py-3 bg-light">
                            <h6 class="mb-0 fw-semibold text-dark">
                                <i class="ti ti-calendar-time me-1 text-primary"></i> Delivery & Payment Summary
                            </h6>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-sm-6">
                                    <label for="delivery_date" class="form-label fw-semibold small">
                                        Delivery Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="delivery_date" name="delivery_date" class="form-control"
                                        value="{{ old('delivery_date', $order->delivery_date ?? '') }}" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="delivery_time" class="form-label fw-semibold small">
                                        Delivery Time Slot <span class="text-danger">*</span>
                                    </label>
                                    <select id="delivery_time" name="delivery_time" class="form-select" required>
                                        @foreach ($timeSlots['time_ranges'] as $time)
                                            <option value="{{ $time['start'] }}"
                                                {{ old('delivery_time', $order->delivery_time ?? '') == $time['start'] ? 'selected' : '' }}>
                                                {{ $time['range'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="discount" class="form-label fw-semibold small">Apply Discount</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="ti ti-tag"></i></span>
                                        <select name="discount" id="discount" class="form-select">
                                            <option value="0" selected>No Discount (0%)</option>
                                            @foreach ($discounts as $disc)
                                                <option value="{{ $disc->amount }}">{{ $disc->name }} ({{ $disc->amount }}%)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary Box -->
                            <div class="order-summary-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted fw-semibold">Gross Total:</span>
                                    <span class="fw-bold text-dark font-monospace fs-6">₹ <span id="grossTotal">0.00</span></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted fw-semibold">Discount Amount:</span>
                                    <span class="fw-bold text-danger font-monospace fs-6">- ₹ <span id="discountAmount">0.00</span></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted fw-semibold">Total Garments:</span>
                                    <span class="badge bg-label-info font-monospace fs-7" id="totalQty">0 pc</span>
                                </div>
                                <hr class="my-2 border-secondary-subtle">
                                <div class="d-flex justify-content-between align-items-center pt-1">
                                    <span class="fw-bold text-primary fs-5">Net Payable:</span>
                                    <span class="fw-bold text-primary fs-4 font-monospace">₹ <span id="totalAmount">0.00</span></span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" id="submitOrderBtn" class="btn btn-primary w-100 py-3 fs-6 fw-semibold shadow-sm">
                                    <i class="ti ti-check me-2"></i> Save & Place Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= RIGHT COLUMN: Garment Catalog & Services ================= -->
                <div class="col-lg-6 col-xl-6">
                    <div class="card pos-card h-100">
                        <div class="card-header border-bottom py-3 bg-light">
                            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
                                <h6 class="mb-0 fw-semibold text-dark">
                                    <i class="ti ti-layout-grid me-1 text-primary"></i> Garment Catalog & Rates
                                </h6>
                                <span class="text-muted small">Click <strong>Add</strong> to configure services</span>
                            </div>
                            <div class="mt-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-search"></i></span>
                                    <input type="search" class="form-control border-start-0 ps-0"
                                        placeholder="Search garments (e.g. Shirt, Saree, Blanket)..." id="searchItem" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 p-md-4 catalog-container">
                            <div id="catalogEmptySearch" class="alert alert-warning py-3 text-center" style="display: none;">
                                <i class="ti ti-search-off me-1"></i> No matching garments found.
                            </div>

                            <div id="catalogCardsContainer">
                                @foreach ($groupedProductItems as $groupedProductItem)
                                    @php
                                        $productItem = $groupedProductItem['product_item'];
                                        $groupedDetails = $groupedProductItem['grouped_details'];
                                    @endphp
                                    <div class="catalog-item-card" data-product-id="{{ $productItem->id }}" data-product-name="{{ strtolower($productItem->name) }}">
                                        <div class="d-flex align-items-start justify-content-between gap-2">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <h6 class="mb-0 fw-bold text-dark fs-6">{{ $productItem->name }}</h6>
                                                    @if ($productItem->name === 'Laundry By Weight')
                                                        <span class="badge bg-label-warning rounded-pill small">By Weight (Kg)</span>
                                                    @endif
                                                </div>

                                                <!-- Categories Pills -->
                                                <div class="category-chips-list mb-2" id="catalog-categories-{{ $productItem->id }}">
                                                    @foreach ($groupedDetails as $category => $services)
                                                        <span class="badge-chip {{ $loop->first ? 'active' : 'inactive' }}"
                                                            onclick="OrderPOS.selectCatalogCategory({{ $productItem->id }}, '{{ addslashes($category) }}')">
                                                            {{ $category }}
                                                        </span>
                                                    @endforeach
                                                </div>

                                                <!-- Services preview for active category -->
                                                <div class="catalog-services-preview small text-muted" id="catalog-services-{{ $productItem->id }}">
                                                    <!-- Filled dynamically by OrderPOS -->
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-outline-primary btn-sm px-3"
                                                    onclick="OrderPOS.openItemModal({{ $productItem->id }})">
                                                    <i class="ti ti-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ================= OFFCANVAS: Item Configurator Drawer ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 440px;">
    <div class="offcanvas-header border-bottom bg-light">
        <h5 class="offcanvas-title fw-bold text-dark" id="offcanvasRightLabel">
            <i class="ti ti-edit text-primary me-1"></i> <span id="popupProductName">Configure Garment</span>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <!-- 1. Category Selection -->
        <div class="mb-4">
            <label class="form-label fw-bold text-dark small text-uppercase mb-2">Select Category</label>
            <div id="popupCategories" class="d-flex flex-wrap gap-2">
                <!-- Dynamically populated -->
            </div>
        </div>

        <!-- 2. Services Selection -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <label class="form-label fw-bold text-dark small text-uppercase mb-0">Select Services</label>
                <span class="badge bg-label-primary font-monospace small" id="popupServiceRatePreview">₹ 0.00 / pc</span>
            </div>
            <div id="popupServices" class="d-flex flex-column gap-2">
                <!-- Dynamically populated -->
            </div>
        </div>

        <!-- 3. Laundry By Weight Garments Breakdown (Only for Laundry By Weight) -->
        <div class="mb-4 p-3 rounded bg-light border" id="garmentDetailsContainer" style="display: none;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <label class="form-label fw-bold text-dark small text-uppercase mb-0">Garment Breakdown</label>
                <button type="button" class="btn btn-sm btn-outline-primary" id="openGarmentPickerBtn">
                    <i class="ti ti-plus me-1"></i> Add Garments
                </button>
            </div>
            <p class="small text-muted mb-2">Specify the clothes included in this weight bundle (optional for tracking):</p>
            <div id="selectedGarmentsList" class="d-flex flex-wrap gap-2">
                <span class="text-muted small fst-italic">No garments picked yet.</span>
            </div>
        </div>

        <!-- 4. Quantity / Weight Section -->
        <div class="mb-4">
            <!-- Piece Count Controls -->
            <div id="pieceCountSection">
                <label class="form-label fw-bold text-dark small text-uppercase mb-2">Garment Count (Pieces)</label>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="stepper-btn" onclick="OrderPOS.adjustModalQty(-1)">
                        <i class="ti ti-minus"></i>
                    </button>
                    <input type="number" class="stepper-input form-control text-center fs-5" id="qtyPlsMns" value="1" min="1" max="999" />
                    <button type="button" class="stepper-btn" onclick="OrderPOS.adjustModalQty(1)">
                        <i class="ti ti-plus"></i>
                    </button>
                    <span class="text-muted small">piece(s)</span>
                </div>
            </div>

            <!-- Laundry By Weight (KG) Controls -->
            <div id="weightSection" style="display: none;">
                <label class="form-label fw-bold text-dark small text-uppercase mb-2">Total Weight in (KG) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="ti ti-scale"></i></span>
                    <input type="number" step="0.05" min="0.1" class="form-control fs-5" id="lundaryweight"
                        placeholder="e.g. 3.5" />
                    <span class="input-group-text bg-light fw-bold">Kg</span>
                </div>
            </div>
        </div>

        <!-- Item Subtotal Preview -->
        <div class="p-3 rounded bg-light border mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-semibold text-muted">Item Subtotal:</span>
                <span class="fw-bold text-primary fs-5 font-monospace" id="modalSubtotalPreview">₹ 0.00</span>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top bg-light">
        <button type="button" id="confirmAddCartBtn" class="btn btn-primary w-100 py-2 fs-6 fw-semibold shadow-sm">
            <i class="ti ti-check me-1"></i> Add to Order
        </button>
    </div>
</div>

<!-- ================= MODAL: Laundry Garment Breakdown Picker ================= -->
<div class="modal fade" id="garmentItemsModal" tabindex="-1" aria-labelledby="garmentItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold text-dark" id="garmentItemsModalLabel">
                    <i class="ti ti-shirt text-primary me-1"></i> Select Bundle Garments
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="garmentModalSearch"
                            placeholder="Filter garments (e.g. Shirt, Pant, Kurta)..." autocomplete="off" />
                    </div>
                </div>

                <div class="row g-3" id="garmentModalList" style="max-height: 55vh; overflow-y: auto;">
                    <!-- Dynamically populated -->
                </div>
            </div>
            <div class="modal-footer border-top bg-light justify-content-between">
                <div class="small fw-semibold text-muted">
                    Total Selected: <span id="garmentModalTotalBadge" class="badge bg-primary">0 pcs</span>
                </div>
                <button type="button" class="btn btn-primary px-4" id="confirmGarmentModalBtn">
                    <i class="ti ti-check me-1"></i> Done & Apply
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================= ORDER POS LOGIC ================= -->
<script>
/**
 * WashFlow Modern State-Driven Order POS Counter Controller
 */
const OrderPOS = (function () {
    // 1. Data passed from Controller
    const rawCatalog = @json($groupedProductItems);

    // 2. State
    let cart = []; // Array of cart items
    let activeModalItem = null; // Currently configuring item in offcanvas
    let garmentBundleSelections = {}; // Temp store for Laundry by weight garments

    // 3. Cached DOM References
    let dom = {};

    function init() {
        cacheDOM();
        bindEvents();
        initDefaultCatalogPreviews();
        renderCart();
        updateTotals();
    }

    function cacheDOM() {
        dom.form = document.getElementById('addOrderFormValidation');
        dom.submitBtn = document.getElementById('submitOrderBtn');
        dom.clientNum = document.getElementById('number');
        dom.clientName = document.getElementById('client_name');
        dom.clientLookupFeedback = document.getElementById('clientLookupFeedback');
        dom.customerStatusBadge = document.getElementById('customerStatusBadge');
        dom.discountSelect = document.getElementById('discount');
        dom.deliveryDate = document.getElementById('delivery_date');
        dom.searchItem = document.getElementById('searchItem');
        dom.catalogContainer = document.getElementById('catalogCardsContainer');
        dom.catalogEmptySearch = document.getElementById('catalogEmptySearch');

        // Cart
        dom.cartEmptyState = document.getElementById('cartEmptyState');
        dom.cartItemsContainer = document.getElementById('cartItemsContainer');
        dom.cartTableBody = document.getElementById('cartTableBody');
        dom.cartItemCountBadge = document.getElementById('cartItemCountBadge');
        dom.hiddenInputsContainer = document.getElementById('hiddenInputsContainer');

        // Summary
        dom.grossTotal = document.getElementById('grossTotal');
        dom.discountAmount = document.getElementById('discountAmount');
        dom.totalQty = document.getElementById('totalQty');
        dom.totalAmount = document.getElementById('totalAmount');
        dom.hiddenGrossTotal = document.getElementById('gross_total');
        dom.hiddenTotalQty = document.getElementById('total_qty');

        // Offcanvas
        dom.offcanvasEl = document.getElementById('offcanvasRight');
        dom.offcanvasInstance = new bootstrap.Offcanvas(dom.offcanvasEl);
        dom.popupProductName = document.getElementById('popupProductName');
        dom.popupCategories = document.getElementById('popupCategories');
        dom.popupServices = document.getElementById('popupServices');
        dom.popupServiceRatePreview = document.getElementById('popupServiceRatePreview');
        dom.pieceCountSection = document.getElementById('pieceCountSection');
        dom.weightSection = document.getElementById('weightSection');
        dom.qtyPlsMns = document.getElementById('qtyPlsMns');
        dom.lundaryweight = document.getElementById('lundaryweight');
        dom.garmentDetailsContainer = document.getElementById('garmentDetailsContainer');
        dom.openGarmentPickerBtn = document.getElementById('openGarmentPickerBtn');
        dom.selectedGarmentsList = document.getElementById('selectedGarmentsList');
        dom.modalSubtotalPreview = document.getElementById('modalSubtotalPreview');
        dom.confirmAddCartBtn = document.getElementById('confirmAddCartBtn');

        // Garment Modal
        dom.garmentModalEl = document.getElementById('garmentItemsModal');
        dom.garmentModalInstance = new bootstrap.Modal(dom.garmentModalEl);
        dom.garmentModalSearch = document.getElementById('garmentModalSearch');
        dom.garmentModalList = document.getElementById('garmentModalList');
        dom.garmentModalTotalBadge = document.getElementById('garmentModalTotalBadge');
        dom.confirmGarmentModalBtn = document.getElementById('confirmGarmentModalBtn');
    }

    function bindEvents() {
        // Customer phone number debounced lookup
        dom.clientNum.addEventListener('input', debounce(function () {
            validateClientNum(this);
            const num = this.value.trim();
            if (num.length === 10) {
                lookupClient(num);
            } else {
                dom.clientLookupFeedback.textContent = '';
                dom.customerStatusBadge.textContent = 'Counter Walk-in';
                dom.customerStatusBadge.className = 'badge bg-label-primary rounded-pill small';
            }
        }, 300));

        // Client name input clean-up
        dom.clientName.addEventListener('input', function () {
            validateClientName(this);
        });

        // Catalog search filter
        dom.searchItem.addEventListener('input', debounce(function () {
            const query = this.value.trim().toLowerCase();
            filterCatalog(query);
        }, 200));

        // Discount selection change
        dom.discountSelect.addEventListener('change', function () {
            updateTotals();
        });

        // Stepper direct input formatting
        dom.qtyPlsMns.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (parseInt(this.value, 10) < 1 || isNaN(parseInt(this.value, 10))) {
                this.value = '1';
            }
            if (activeModalItem) {
                activeModalItem.qty = parseInt(this.value, 10);
                updateModalSubtotal();
            }
        });

        // Weight input formatting
        dom.lundaryweight.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9.]/g, '');
            if (activeModalItem) {
                activeModalItem.weight = parseFloat(this.value) || 0;
                updateModalSubtotal();
            }
        });

        // Offcanvas add to cart
        dom.confirmAddCartBtn.addEventListener('click', addActiveItemToCart);

        // Laundry garment picker modal open
        dom.openGarmentPickerBtn.addEventListener('click', openGarmentPickerModal);

        // Laundry garment picker search
        dom.garmentModalSearch.addEventListener('input', debounce(function () {
            filterGarmentModal(this.value.trim().toLowerCase());
        }, 150));

        // Confirm Garment modal selections
        dom.confirmGarmentModalBtn.addEventListener('click', confirmGarmentModalSelections);

        // Form submission
        dom.form.addEventListener('submit', handleFormSubmit);
    }

    // Debounce helper
    function debounce(fn, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // Input sanitizers
    function validateClientNum(input) {
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
    }

    function validateClientName(input) {
        input.value = input.value.replace(/[^a-zA-Z\s.]/g, '').slice(0, 30);
    }

    // Lookup customer by phone number
    function lookupClient(clientNum) {
        dom.clientLookupFeedback.innerHTML = '<span class="text-muted"><i class="ti ti-loader fa-spin me-1"></i> Checking customer...</span>';
        fetch(`{{ url('/admin/fetch-client-name') }}?client_num=${encodeURIComponent(clientNum)}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.client_name) {
                dom.clientName.value = data.client_name;
                dom.clientLookupFeedback.innerHTML = `<span class="text-success"><i class="ti ti-check me-1"></i> Found existing customer: <strong>${data.client_name}</strong></span>`;
                dom.customerStatusBadge.textContent = 'Existing Client';
                dom.customerStatusBadge.className = 'badge bg-label-success rounded-pill small';
            } else {
                dom.clientLookupFeedback.innerHTML = '<span class="text-muted"><i class="ti ti-user-plus me-1"></i> New customer. Please enter name.</span>';
                dom.customerStatusBadge.textContent = 'New Customer';
                dom.customerStatusBadge.className = 'badge bg-label-info rounded-pill small';
            }
        })
        .catch(err => {
            console.error('Lookup failed', err);
            dom.clientLookupFeedback.textContent = '';
        });
    }

    // Initialize the default services preview for each catalog card
    function initDefaultCatalogPreviews() {
        rawCatalog.forEach(entry => {
            const pId = entry.product_item.id;
            const details = entry.grouped_details;
            const categories = Object.keys(details);
            if (categories.length > 0) {
                selectCatalogCategory(pId, categories[0]);
            }
        });
    }

    // Change category in catalog card
    function selectCatalogCategory(productId, categoryName) {
        const item = rawCatalog.find(e => e.product_item.id === productId);
        if (!item) return;

        // Update active chip in catalog card
        const chipsContainer = document.getElementById(`catalog-categories-${productId}`);
        if (chipsContainer) {
            chipsContainer.querySelectorAll('.badge-chip').forEach(chip => {
                if (chip.textContent.trim() === categoryName) {
                    chip.className = 'badge-chip active';
                } else {
                    chip.className = 'badge-chip inactive';
                }
            });
        }

        // Render services preview
        const previewContainer = document.getElementById(`catalog-services-${productId}`);
        if (previewContainer) {
            const servicesObj = item.grouped_details[categoryName] || {};
            const unit = (categoryName.trim() === 'Laundry By Weight' || item.product_item.name === 'Laundry By Weight') ? 'Kg' : 'pc';
            
            const badges = [];
            for (const sName in servicesObj) {
                const list = servicesObj[sName];
                const price = (list && list[0]) ? list[0].price : 0;
                badges.push(`<span class="badge bg-label-secondary me-1 mb-1">${sName}: ₹${price}/${unit}</span>`);
            }
            previewContainer.innerHTML = badges.length > 0 ? badges.join('') : '<span class="text-muted fst-italic">No services configured</span>';
        }
    }

    // Filter catalog items
    function filterCatalog(query) {
        const cards = dom.catalogContainer.querySelectorAll('.catalog-item-card');
        let visible = 0;
        cards.forEach(card => {
            const name = card.getAttribute('data-product-name') || '';
            const isMatch = name.includes(query);
            card.style.display = isMatch ? '' : 'none';
            if (isMatch) visible++;
        });
        dom.catalogEmptySearch.style.display = (visible === 0) ? 'block' : 'none';
    }

    // ================= OFFCANVAS CONFIGURATOR =================
    function openItemModal(productId) {
        const item = rawCatalog.find(e => e.product_item.id === productId);
        if (!item) return;

        const isLaundryByWeight = item.product_item.name === 'Laundry By Weight';

        // Setup active modal state
        activeModalItem = {
            productId: item.product_item.id,
            name: item.product_item.name,
            categories: item.grouped_details,
            selectedCategory: '',
            selectedServices: [],
            qty: 1,
            weight: isLaundryByWeight ? 1.0 : 0,
            unit: isLaundryByWeight ? 'Kg' : 'pc',
            garments: []
        };

        garmentBundleSelections = {}; // Reset bundle picker

        dom.popupProductName.textContent = item.product_item.name;

        // Render category options
        dom.popupCategories.innerHTML = '';
        const catKeys = Object.keys(item.grouped_details);
        catKeys.forEach((cat, index) => {
            const chip = document.createElement('span');
            chip.className = `badge-chip ${index === 0 ? 'active' : 'inactive'}`;
            chip.textContent = cat;
            chip.onclick = () => selectOffcanvasCategory(cat);
            dom.popupCategories.appendChild(chip);
        });

        // Set inputs based on item type
        if (isLaundryByWeight) {
            dom.pieceCountSection.style.display = 'none';
            dom.weightSection.style.display = 'block';
            dom.garmentDetailsContainer.style.display = 'block';
            dom.lundaryweight.value = '1.0';
            dom.qtyPlsMns.value = '0';
            renderSelectedGarmentsPreview();
        } else {
            dom.pieceCountSection.style.display = 'block';
            dom.weightSection.style.display = 'none';
            dom.garmentDetailsContainer.style.display = 'none';
            dom.qtyPlsMns.value = '1';
        }

        // Select initial category
        if (catKeys.length > 0) {
            selectOffcanvasCategory(catKeys[0]);
        }

        dom.offcanvasInstance.show();
    }

    function selectOffcanvasCategory(categoryName) {
        if (!activeModalItem) return;
        activeModalItem.selectedCategory = categoryName;

        // Update active badge in offcanvas
        dom.popupCategories.querySelectorAll('.badge-chip').forEach(chip => {
            if (chip.textContent.trim() === categoryName) {
                chip.className = 'badge-chip active';
            } else {
                chip.className = 'badge-chip inactive';
            }
        });

        const isWeight = (categoryName.trim() === 'Laundry By Weight' || activeModalItem.name === 'Laundry By Weight');
        activeModalItem.unit = isWeight ? 'Kg' : 'pc';

        if (isWeight) {
            dom.pieceCountSection.style.display = 'none';
            dom.weightSection.style.display = 'block';
            dom.garmentDetailsContainer.style.display = 'block';
        } else {
            dom.pieceCountSection.style.display = 'block';
            dom.weightSection.style.display = 'none';
            dom.garmentDetailsContainer.style.display = 'none';
        }

        // Populate services
        renderOffcanvasServices();
        updateModalSubtotal();
    }

    function renderOffcanvasServices() {
        dom.popupServices.innerHTML = '';
        activeModalItem.selectedServices = []; // Reset selections

        const servicesObj = activeModalItem.categories[activeModalItem.selectedCategory] || {};
        const isWeight = activeModalItem.unit === 'Kg';

        // Add standard Laundry by Weight services if not already in servicesObj
        const serviceMap = { ...servicesObj };
        if (isWeight) {
            if (!serviceMap['AV']) serviceMap['AV'] = [{ price: 5, service: 'AV' }];
            if (!serviceMap['FS']) serviceMap['FS'] = [{ price: 5, service: 'FS' }];
        }

        const keys = Object.keys(serviceMap);
        if (keys.length === 0) {
            dom.popupServices.innerHTML = '<div class="alert alert-warning py-2 small mb-0">No services found for this category.</div>';
            return;
        }

        keys.forEach((serviceName, idx) => {
            const detailList = serviceMap[serviceName];
            const price = (detailList && detailList[0]) ? parseFloat(detailList[0].price) : 0;

            const chip = document.createElement('div');
            chip.className = 'service-chip';
            chip.setAttribute('data-service-name', serviceName);
            chip.setAttribute('data-service-price', price);

            chip.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-check-circle service-check-icon opacity-50"></i>
                    <span class="fw-semibold small">${serviceName}</span>
                </div>
                <span class="service-price-tag">₹ ${price.toFixed(2)} / ${activeModalItem.unit}</span>
            `;

            chip.onclick = () => toggleOffcanvasService(serviceName, price, chip);
            dom.popupServices.appendChild(chip);

            // Auto-select the first service by default for convenience
            if (idx === 0) {
                toggleOffcanvasService(serviceName, price, chip);
            }
        });
    }

    function toggleOffcanvasService(serviceName, price, chipEl) {
        if (!activeModalItem) return;

        // Mutual Exclusivity Rules:
        // Rule 1: DC (Dry Clean) vs SP (Steam Press) / ST (Starch)
        if (serviceName === 'DC') {
            deselectOffcanvasService('SP');
            deselectOffcanvasService('ST');
        } else if (serviceName === 'SP' || serviceName === 'ST') {
            deselectOffcanvasService('DC');
        }

        // Rule 2: WF (Wash & Fold), WI (Wash & Iron), PL (Premium Laundry) are mutually exclusive
        if (serviceName === 'WF') {
            deselectOffcanvasService('WI');
            deselectOffcanvasService('PL');
        } else if (serviceName === 'WI') {
            deselectOffcanvasService('WF');
            deselectOffcanvasService('PL');
        } else if (serviceName === 'PL') {
            deselectOffcanvasService('WF');
            deselectOffcanvasService('WI');
        }

        // Check if currently selected
        const existingIdx = activeModalItem.selectedServices.findIndex(s => s.service === serviceName);
        if (existingIdx >= 0) {
            // Deselect
            activeModalItem.selectedServices.splice(existingIdx, 1);
            chipEl.classList.remove('selected');
            const icon = chipEl.querySelector('.service-check-icon');
            if (icon) icon.className = 'ti ti-check-circle service-check-icon opacity-50';
        } else {
            // Select
            activeModalItem.selectedServices.push({ service: serviceName, price: price });
            chipEl.classList.add('selected');
            const icon = chipEl.querySelector('.service-check-icon');
            if (icon) icon.className = 'ti ti-circle-check-filled service-check-icon';
        }

        updateModalSubtotal();
    }

    function deselectOffcanvasService(serviceName) {
        if (!activeModalItem) return;
        const idx = activeModalItem.selectedServices.findIndex(s => s.service === serviceName);
        if (idx >= 0) {
            activeModalItem.selectedServices.splice(idx, 1);
            const chip = dom.popupServices.querySelector(`[data-service-name="${serviceName}"]`);
            if (chip) {
                chip.classList.remove('selected');
                const icon = chip.querySelector('.service-check-icon');
                if (icon) icon.className = 'ti ti-check-circle service-check-icon opacity-50';
            }
        }
    }

    function adjustModalQty(delta) {
        if (!activeModalItem) return;
        let cur = parseInt(dom.qtyPlsMns.value, 10) || 1;
        cur += delta;
        if (cur < 1) cur = 1;
        dom.qtyPlsMns.value = cur;
        activeModalItem.qty = cur;
        updateModalSubtotal();
    }

    function updateModalSubtotal() {
        if (!activeModalItem) return;

        const sumRates = activeModalItem.selectedServices.reduce((acc, s) => acc + s.price, 0);
        dom.popupServiceRatePreview.textContent = `₹ ${sumRates.toFixed(2)} / ${activeModalItem.unit}`;

        let total = 0;
        if (activeModalItem.unit === 'Kg') {
            const weight = parseFloat(dom.lundaryweight.value) || 0;
            total = weight * sumRates;
        } else {
            const qty = parseInt(dom.qtyPlsMns.value, 10) || 1;
            total = qty * sumRates;
        }

        dom.modalSubtotalPreview.textContent = `₹ ${total.toFixed(2)}`;
    }

    // ================= LAUNDRY GARMENT BREAKDOWN MODAL =================
    function openGarmentPickerModal() {
        dom.garmentModalSearch.value = '';
        renderGarmentModalList('');
        dom.garmentModalInstance.show();
    }

    function renderGarmentModalList(filter) {
        dom.garmentModalList.innerHTML = '';

        // Filter out Laundry By Weight and specialized items
        const availableItems = rawCatalog.filter(e => {
            const n = e.product_item.name;
            return n !== 'Laundry By Weight' && n !== 'Shoe' && n !== 'Gloves' && n !== 'Socks/Stocking Pair' && n !== 'Slip on';
        });

        let totalPieces = 0;

        availableItems.forEach(entry => {
            const pId = entry.product_item.id;
            const pName = entry.product_item.name;
            const catKeys = Object.keys(entry.grouped_details);
            const defaultCat = catKeys.length > 0 ? catKeys[0] : 'General';

            if (filter && !pName.toLowerCase().includes(filter)) {
                return;
            }

            const currentCount = garmentBundleSelections[pId] ? garmentBundleSelections[pId].qty : 0;
            totalPieces += currentCount;

            const col = document.createElement('div');
            col.className = 'col-12 col-md-6';
            col.innerHTML = `
                <div class="border rounded p-3 d-flex align-items-center justify-content-between bg-white shadow-none">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark fs-6">${pName}</h6>
                        <span class="badge bg-label-secondary small">${defaultCat}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="stepper-btn" onclick="OrderPOS.adjustGarmentModalPiece(${pId}, '${pName}', '${defaultCat}', -1)">
                            <i class="ti ti-minus"></i>
                        </button>
                        <span class="fw-bold font-monospace px-2 fs-6" id="garmentModalPieceVal-${pId}">${currentCount}</span>
                        <button type="button" class="stepper-btn" onclick="OrderPOS.adjustGarmentModalPiece(${pId}, '${pName}', '${defaultCat}', 1)">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            `;
            dom.garmentModalList.appendChild(col);
        });

        dom.garmentModalTotalBadge.textContent = `${totalPieces} pcs`;
    }

    function adjustGarmentModalPiece(id, name, cat, change) {
        if (!garmentBundleSelections[id]) {
            garmentBundleSelections[id] = { id: id, name: name, category: cat, qty: 0 };
        }
        let cur = garmentBundleSelections[id].qty + change;
        if (cur < 0) cur = 0;
        garmentBundleSelections[id].qty = cur;

        const valEl = document.getElementById(`garmentModalPieceVal-${id}`);
        if (valEl) valEl.textContent = cur;

        // Update total
        let total = 0;
        for (const k in garmentBundleSelections) {
            total += garmentBundleSelections[k].qty;
        }
        dom.garmentModalTotalBadge.textContent = `${total} pcs`;
    }

    function filterGarmentModal(q) {
        renderGarmentModalList(q);
    }

    function confirmGarmentModalSelections() {
        if (!activeModalItem) return;

        const garments = [];
        let totalCount = 0;
        for (const k in garmentBundleSelections) {
            const item = garmentBundleSelections[k];
            if (item.qty > 0) {
                garments.push({
                    name: item.name,
                    category: item.category,
                    qty: item.qty
                });
                totalCount += item.qty;
            }
        }

        activeModalItem.garments = garments;
        activeModalItem.qty = totalCount;
        dom.qtyPlsMns.value = totalCount;

        renderSelectedGarmentsPreview();
        dom.garmentModalInstance.hide();
    }

    function renderSelectedGarmentsPreview() {
        if (!activeModalItem) return;
        if (!activeModalItem.garments || activeModalItem.garments.length === 0) {
            dom.selectedGarmentsList.innerHTML = '<span class="text-muted small fst-italic">No garments picked yet.</span>';
            return;
        }

        const tags = activeModalItem.garments.map(g =>
            `<span class="badge bg-label-primary font-monospace">${g.qty}x ${g.name} (${g.category})</span>`
        );
        dom.selectedGarmentsList.innerHTML = tags.join('');
    }

    // ================= CART OPERATIONS =================
    function addActiveItemToCart() {
        if (!activeModalItem) return;

        // Validation
        if (!activeModalItem.selectedCategory) {
            alert('Please select a category.');
            return;
        }
        if (activeModalItem.selectedServices.length === 0) {
            alert('Please select at least one service.');
            return;
        }

        const isWeight = activeModalItem.unit === 'Kg';
        const weightVal = parseFloat(dom.lundaryweight.value) || 0;
        const qtyVal = parseInt(dom.qtyPlsMns.value, 10) || 1;

        if (isWeight && weightVal <= 0) {
            alert('Weight must be greater than 0 Kg.');
            dom.lundaryweight.focus();
            return;
        }
        if (!isWeight && qtyVal < 1) {
            alert('Quantity must be at least 1.');
            dom.qtyPlsMns.focus();
            return;
        }

        const sumRates = activeModalItem.selectedServices.reduce((acc, s) => acc + s.price, 0);
        const serviceNames = activeModalItem.selectedServices.map(s => s.service).join(', ');
        const lineTotal = isWeight ? (weightVal * sumRates) : (qtyVal * sumRates);

        // Check if duplicate item exists in cart
        const existingIdx = cart.findIndex(c =>
            c.name === activeModalItem.name &&
            c.category === activeModalItem.selectedCategory &&
            c.serviceStr === serviceNames
        );

        if (existingIdx >= 0) {
            // Increment existing
            if (isWeight) {
                cart[existingIdx].weight = parseFloat((cart[existingIdx].weight + weightVal).toFixed(2));
                cart[existingIdx].qty += qtyVal;
                cart[existingIdx].total = parseFloat((cart[existingIdx].weight * sumRates).toFixed(2));
                // Merge garments if any
                if (activeModalItem.garments && activeModalItem.garments.length > 0) {
                    cart[existingIdx].garments = [...cart[existingIdx].garments, ...activeModalItem.garments];
                }
            } else {
                cart[existingIdx].qty += qtyVal;
                cart[existingIdx].total = parseFloat((cart[existingIdx].qty * sumRates).toFixed(2));
            }
        } else {
            // New cart item
            cart.push({
                uid: 'cart_' + Date.now() + '_' + Math.floor(Math.random() * 1000),
                name: activeModalItem.name,
                category: activeModalItem.selectedCategory,
                serviceStr: serviceNames,
                unitPrice: sumRates,
                qty: qtyVal,
                weight: isWeight ? weightVal : 0,
                unit: isWeight ? 'Kg' : 'Unit',
                total: parseFloat(lineTotal.toFixed(2)),
                garments: activeModalItem.garments ? [...activeModalItem.garments] : []
            });
        }

        dom.offcanvasInstance.hide();
        renderCart();
        updateTotals();
    }

    function removeCartItem(uid) {
        cart = cart.filter(c => c.uid !== uid);
        renderCart();
        updateTotals();
    }

    function renderCart() {
        if (cart.length === 0) {
            dom.cartEmptyState.style.display = 'block';
            dom.cartItemsContainer.style.display = 'none';
            dom.cartTableBody.innerHTML = '';
            dom.cartItemCountBadge.textContent = '0 items';
            dom.hiddenInputsContainer.innerHTML = '';
            return;
        }

        dom.cartEmptyState.style.display = 'none';
        dom.cartItemsContainer.style.display = 'block';
        dom.cartItemCountBadge.textContent = `${cart.length} item${cart.length > 1 ? 's' : ''}`;

        let rowsHtml = '';
        let hiddenHtml = '';

        cart.forEach((item, index) => {
            const isWeight = item.unit === 'Kg';
            const qtyDisplay = isWeight ? `${item.weight} Kg` : `${item.qty} pc`;

            let subItemsDisplay = '';
            if (isWeight && item.garments && item.garments.length > 0) {
                const garmentPills = item.garments.map((g, gIdx) => {
                    hiddenHtml += `
                        <input type="hidden" name="lundaryProductName[${index}][]" value="${escapeHtml(g.name)}" />
                        <input type="hidden" name="lundaryProductQty[${index}][]" value="${g.qty}" />
                        <input type="hidden" name="lundaryProductCategroyId[${index}][]" value="${escapeHtml(g.category)}" />
                    `;
                    return `<span class="badge bg-label-secondary font-monospace fs-8">${g.qty}x ${escapeHtml(g.name)}</span>`;
                }).join(' ');

                subItemsDisplay = `<div class="mt-1 d-flex flex-wrap gap-1">${garmentPills}</div>`;
            }

            rowsHtml += `
                <tr>
                    <td>
                        <div class="fw-bold text-dark">${escapeHtml(item.name)}</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-label-info font-monospace fs-8">${escapeHtml(item.category)}</span>
                            <span class="badge bg-label-primary font-monospace fs-8">${escapeHtml(item.serviceStr)}</span>
                        </div>
                        ${subItemsDisplay}
                    </td>
                    <td class="text-center font-monospace fw-bold">${qtyDisplay}</td>
                    <td class="text-end font-monospace">₹ ${item.unitPrice.toFixed(2)}</td>
                    <td class="text-end font-monospace fw-bold text-primary">₹ ${item.total.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm p-1 rounded-circle border-0"
                            title="Remove" onclick="OrderPOS.removeCartItem('${item.uid}')">
                            <i class="ti ti-trash fs-5"></i>
                        </button>
                    </td>
                </tr>
            `;

            // Required form arrays expected by OrderController::addOrder()
            hiddenHtml += `
                <input type="hidden" name="itemname[]" value="${escapeHtml(item.name)}" />
                <input type="hidden" name="itemcategory[]" value="${escapeHtml(item.category)}" />
                <input type="hidden" name="itemservice[]" value="${escapeHtml(item.serviceStr)}" />
                <input type="hidden" name="itemqty[]" value="${item.qty}" />
                <input type="hidden" name="itemprice[]" value="${item.unitPrice.toFixed(2)}" />
                <input type="hidden" name="qtyxprice[]" value="${item.total.toFixed(2)}" />
                <input type="hidden" name="clothlundaryqty[]" value="${item.weight}" />
                <input type="hidden" name="unit[]" value="${item.unit}" />
            `;
        });

        dom.cartTableBody.innerHTML = rowsHtml;
        dom.hiddenInputsContainer.innerHTML = hiddenHtml;
    }

    function updateTotals() {
        let gross = 0;
        let pieces = 0;

        cart.forEach(item => {
            gross += item.total;
            pieces += item.qty;
        });

        const discountRate = parseFloat(dom.discountSelect.value) || 0;
        const discountAmt = gross * (discountRate / 100);
        const net = Math.max(0, gross - discountAmt);

        dom.grossTotal.textContent = gross.toFixed(2);
        dom.discountAmount.textContent = discountAmt.toFixed(2);
        dom.totalQty.textContent = `${pieces} pc`;
        dom.totalAmount.textContent = net.toFixed(2);

        dom.hiddenGrossTotal.value = gross.toFixed(2);
        dom.hiddenTotalQty.value = pieces;
    }

    function escapeHtml(str) {
        return (str || '').replace(/[&<>"']/g, function (m) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
        });
    }

    // ================= FORM SUBMISSION =================
    function handleFormSubmit(e) {
        // Validate Client Number
        const clientNum = dom.clientNum.value.trim();
        if (clientNum.length !== 10 || isNaN(clientNum)) {
            alert('Please enter a valid 10-digit mobile number.');
            dom.clientNum.focus();
            e.preventDefault();
            return false;
        }

        // Validate Client Name
        const clientName = dom.clientName.value.trim();
        if (clientName.length < 2 || clientName.length > 30) {
            alert('Please enter a valid customer name (between 2 and 30 characters).');
            dom.clientName.focus();
            e.preventDefault();
            return false;
        }

        // Validate Delivery Date
        if (!dom.deliveryDate.value) {
            alert('Please select a delivery date.');
            dom.deliveryDate.focus();
            e.preventDefault();
            return false;
        }

        // Validate Cart Count
        if (cart.length === 0) {
            alert('Your cart is empty. Please add at least one garment before placing order.');
            e.preventDefault();
            return false;
        }

        // Disable submit button to prevent double-clicks
        dom.submitBtn.disabled = true;
        dom.submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing Order...';
        return true;
    }

    // Public API
    return {
        init,
        selectCatalogCategory,
        openItemModal,
        adjustModalQty,
        adjustGarmentModalPiece,
        removeCartItem
    };
})();

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', function () {
    OrderPOS.init();
});
</script>
@endsection
