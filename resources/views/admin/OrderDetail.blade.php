@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('viewOrder') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Back to Orders">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="fw-bold mb-0" style="color: #1F446E;">Order Details</h4>
                        <span class="badge bg-label-primary px-3 py-1 fs-7 fw-semibold">
                            #{{ $orders->order_number }}
                        </span>
                        @php
                            $statusLower = strtolower($orders->status ?? 'pending');
                        @endphp
                        @if($statusLower === 'delivered' || $statusLower === 'completed')
                            <span class="badge-status badge-status-delivered">
                                <i class="ti ti-check ti-xs"></i> Delivered
                            </span>
                        @else
                            <span class="badge-status badge-status-pending">
                                <i class="ti ti-clock ti-xs"></i> Pending
                            </span>
                        @endif
                    </div>
                    <small class="text-muted">Recorded on {{ $orders->order_date }} at {{ $orders->order_time }}</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ url('/admin/receipt/' . $orders->id) }}" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                    <i class="ti ti-printer ti-xs"></i> Print Receipt
                </a>
                <a href="{{ url('/admin/tagslist/' . $orders->id) }}" target="_blank" class="btn btn-outline-success btn-sm d-flex align-items-center gap-1">
                    <i class="ti ti-tag ti-xs"></i> Garment Tags
                </a>
                @if(($orders->paymentDetail->status ?? '') !== 'Paid' || $orders->status !== 'delivered')
                    <a href="{{ route('order.edit', $orders->id) }}" class="btn btn_1F446E_hp btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-pencil ti-xs"></i> Edit Order
                    </a>
                @endif
            </div>
        </div>

        <!-- 3 Info Summary Cards Grid -->
        <div class="row g-3 g-md-4 mb-4">
            <!-- Client Card -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar-initial rounded-circle bg-label-primary text-primary fw-bold" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                {{ strtoupper(substr($orders->user->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Client Profile</small>
                                <h6 class="fw-bold mb-0 text-dark">{{ $orders->user->name ?? 'Walk-in Client' }}</h6>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex align-items-center justify-content-between text-muted small py-1">
                                <span>Phone:</span>
                                <span class="fw-semibold text-dark"><i class="ti ti-phone ti-xs text-primary me-1"></i>{{ $orders->user->mobile ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="stat-icon bg-label-info text-info">
                                <i class="ti ti-calendar-time"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Schedule & Delivery</small>
                                <h6 class="fw-bold mb-0 text-dark">Promised Delivery</h6>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex align-items-center justify-content-between text-muted small py-1">
                                <span>Delivery Date:</span>
                                <span class="fw-semibold text-dark">{{ $orders->delivery_date ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between text-muted small py-1">
                                <span>Delivery Time:</span>
                                <span class="fw-semibold text-dark">{{ $orders->delivery_time ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Summary Card -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="stat-icon bg-label-success text-success">
                                <i class="ti ti-cash"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-semibold d-block">Financial Total</small>
                                <h4 class="fw-bold mb-0 text-success">₹ {{ number_format($totalAmount, 2) }}</h4>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex align-items-center justify-content-between text-muted small py-1">
                                <span>Sub-Total:</span>
                                <span class="fw-semibold text-dark">₹ {{ number_format($subTotalAmount, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between text-muted small py-1">
                                <span>Discount ({{ $orders->discounts->amount ?? 0 }}%):</span>
                                <span class="fw-semibold text-danger">- ₹ {{ number_format($discountAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Garment Items Breakdown Table Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-2">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-shirt text-primary"></i> Garment Items in this Booking
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Product Item</th>
                                <th>Category</th>
                                <th>Quantity / Unit</th>
                                <th>Applied Service</th>
                                <th>Unit Rate</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $serial = 1;
                            @endphp
                            @foreach ($orders->orderItems as $orderItem)
                                @php
                                    $service = $orderItem->operation_id;
                                    $linePrice = ($orderItem->unit == 'Kg')
                                        ? ($orderItem->weight * $orderItem->operation_price)
                                        : ($orderItem->quantity * $orderItem->operation_price);
                                @endphp
                                <tr>
                                    <td class="text-muted fw-semibold">{{ $serial++ }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initial rounded-circle bg-label-primary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                <i class="ti ti-tag"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $orderItem->Item->name ?? 'Garment' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info rounded-pill px-2 py-1">
                                            {{ $orderItem->categories->name ?? 'Category' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary rounded-pill px-3 py-1 fw-semibold">
                                            @if ($orderItem->unit == 'Kg')
                                                {{ $orderItem->quantity }} pcs / {{ $orderItem->weight }} kg
                                            @else
                                                {{ $orderItem->quantity }} pcs
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-dark rounded-pill px-2 py-1">
                                            <i class="ti ti-sparkles ti-xs me-1"></i>{{ $service }}
                                        </span>
                                    </td>
                                    <td>₹ {{ number_format($orderItem->operation_price, 2) }}</td>
                                    <td class="text-end fw-bold text-dark fs-6">
                                        ₹ {{ number_format($linePrice, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="5" class="border-0"></td>
                                <td class="fw-semibold text-muted text-end">Sub-Total:</td>
                                <td class="fw-bold text-dark text-end">₹ {{ number_format($subTotalAmount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="border-0"></td>
                                <td class="fw-semibold text-muted text-end">Discount ({{ $orders->discounts->amount ?? 0 }}%):</td>
                                <td class="fw-bold text-danger text-end">- ₹ {{ number_format($discountAmount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="border-0"></td>
                                <td class="fw-bold text-dark text-end fs-6">Grand Total:</td>
                                <td class="fw-bold text-success text-end fs-5">₹ {{ number_format($totalAmount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
