@extends('backend.layouts.app')
@section('content')
<style>
    .no-records-found {
        text-align: center;
        color: #e63946;
        padding: 30px;
        font-size: 15px;
        display: none;
    }
</style>

<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1F446E;">
                    <i class="ti ti-package me-2"></i>Order Management
                </h4>
                <p class="text-muted mb-0 small">Review incoming customer laundry bookings, statuses, and delivery workflows.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('addOrder') }}" class="btn btn_1F446E_hp btn-sm d-flex align-items-center gap-1 shadow-sm">
                    <i class="ti ti-plus ti-xs"></i>
                    <span>Create New Order</span>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-list text-primary"></i> All Orders List
                </h5>
                <div class="w-100 w-sm-auto flex-grow-1 flex-sm-grow-0" style="min-width: 200px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="search" class="form-control border-start-0 ps-0" placeholder="Search order ID, client name..." id="orderSearch">
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Booking ID</th>
                                <th>Client Name</th>
                                <th>Mobile Number</th>
                                <th class="text-center">Items</th>
                                <th class="text-end" style="min-width: 170px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="ti ti-package-off fs-2 d-block mb-2"></i>
                                        No order records found in the system.
                                    </td>
                                </tr>
                            @else
                                @php
                                    $serialNumber = ($orders->currentPage() - 1) * $orders->perPage() + 1;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $serialNumber++ }}</td>
                                        <td>
                                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="fw-bold text-decoration-none">
                                                <span class="badge bg-label-primary px-2 py-1">
                                                    <i class="ti ti-tag ti-xs me-1"></i>#{{ $order->order_number }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-initial rounded-circle bg-label-secondary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                    {{ strtoupper(substr($order->name ?? 'C', 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $order->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex align-items-center gap-1 text-muted">
                                                <i class="ti ti-phone ti-xs text-primary"></i>
                                                <span>{{ $order->mobile }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-label-secondary rounded-pill px-3 py-1 fw-semibold">
                                                {{ $order->total_qty }} pcs
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex align-items-center gap-1 Client_table_action_area">
                                                <!-- View Order -->
                                                <a href="{{ url('/admin/show-order/' . $order->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 Client_table_action_icon" title="View Order">
                                                    <i class="ti ti-eye ti-xs"></i>
                                                </a>

                                                @if ($order->payment_status !== 'Paid' || $order->status !== 'delivered')
                                                    <!-- Edit Order -->
                                                    <button class="btn btn-sm btn-outline-secondary px-2 py-1 Client_table_action_icon"
                                                        onclick="window.location='{{ route('order.edit', $order->id) }}'" title="Edit Order">
                                                        <i class="ti ti-pencil ti-xs"></i>
                                                    </button>

                                                    <!-- Settle Dropdown -->
                                                    <div class="btn-group dropstart order_list_action_menu_dropmenu">
                                                        <button type="button" class="btn btn-sm btn-outline-warning px-2 py-1 dropdown-toggle Client_table_action_icon"
                                                            data-bs-toggle="dropdown" aria-expanded="false" data-order_id="{{ $order->id }}" title="Order Actions">
                                                            <i class="ti ti-layout-grid ti-xs"></i>
                                                        </button>
                                                        <ul class="dropdown-menu shadow border-0 py-1">
                                                            <li>
                                                                <a class="dropdown-item set_ord_btn py-2 text-warning d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#SettleOrder" data-order_id="{{ $order->id }}">
                                                                    <i class="ti ti-cash"></i> Settle & Deliver
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif

                                                <!-- Print / Tags -->
                                                <button type="button" class="btn btn-sm btn-outline-info px-2 py-1 Client_table_action_icon rcp_btn" data-order_id="{{ $order->id }}" title="Print Receipt & Tags">
                                                    <i class="ti ti-printer ti-xs"></i>
                                                </button>

                                                @if ($order->payment_status !== 'Paid' || $order->status !== 'delivered')
                                                    <!-- Delete -->
                                                    <button class="btn btn-sm btn-outline-danger px-2 py-1 Client_table_action_icon delete_order_btn" data-id="{{ $order->id }}" data-bs-toggle="modal" data-bs-target="#delete_order" title="Delete Order">
                                                        <i class="ti ti-trash ti-xs"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="no-records-found">
                    <i class="ti ti-search-off fs-2 d-block mb-2 text-muted"></i>
                    <span>No orders found matching your search.</span>
                </div>

                @if ($orders->count() > 0)
                    <div class="pagination-container p-3 border-top">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Settle Order Modal -->
<div class="modal fade" id="SettleOrder" tabindex="-1" aria-labelledby="SettleOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="SettleOrderLabel" style="color: #1F446E;">
                    <i class="ti ti-wallet me-2"></i>Select Payment Method
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="settleOrderForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded text-center h-100 bg-light">
                                <div class="form-check d-flex flex-column align-items-center">
                                    <input class="form-check-input mb-2" type="radio" name="paymentOption" id="cashOn" value="cash" style="width: 20px; height: 20px;">
                                    <label class="form-check-label fw-semibold cursor-pointer" for="cashOn">
                                        <i class="ti ti-cash fs-3 text-success d-block mb-1"></i> Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded text-center h-100 bg-light">
                                <div class="form-check d-flex flex-column align-items-center">
                                    <input class="form-check-input mb-2" type="radio" name="paymentOption" id="upiPayment" value="Online" style="width: 20px; height: 20px;">
                                    <label class="form-check-label fw-semibold cursor-pointer" for="upiPayment">
                                        <i class="ti ti-qrcode fs-3 text-primary d-block mb-1"></i> UPI / Online
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <span id="paymentError" class="text-danger small mt-1 d-block text-center"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn_1F446E_hp" id="settleAndDeliverButton">
                    <i class="ti ti-check me-1"></i> Settle & Deliver
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Order Modal -->
<div class="modal fade" id="delete_order" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-danger" id="deleteOrderModalLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Confirm Order Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar avatar-lg rounded-circle bg-label-danger mx-auto mb-3" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="ti ti-trash"></i>
                </div>
                <h5 class="fw-semibold mb-1">Are you sure?</h5>
                <p class="text-muted small mb-0">Are you sure you want to delete this order? This action cannot be reversed.</p>
                <form method="post" id="deleteOrderForm">
                    @csrf
                    @method('GET')
                    <input type="hidden" id="order_del_id" name="service_id">
                </form>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger px-4" id="confirm_delete">Delete Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Print Receipt / Tags Modal -->
<div class="modal fade" id="yes" tabindex="-1" aria-labelledby="yesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="yesLabel" style="color: #1F446E;">
                    <i class="ti ti-printer me-2"></i>Print Documents
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted small mb-4">Choose which document you would like to generate and print for this order:</p>
                <div class="d-flex flex-column gap-3">
                    <a href="#" target="_blank" class="btn btn_1F446E_hp py-2 d-flex align-items-center justify-content-center gap-2" id="printReceipt">
                        <i class="ti ti-receipt"></i> Print Customer Receipt
                    </a>
                    <a href="#" target="_blank" class="btn btn-outline-success py-2 d-flex align-items-center justify-content-center gap-2" id="printTags">
                        <i class="ti ti-tag"></i> Print Garment Tags
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#orderSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $.ajax({
                    url: '/admin/view-order',
                    type: 'GET',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        var orders = response.orders;
                        var pagination = response.pagination;
                        var tbody = $('tbody');
                        tbody.empty();
                        var serialNumber = 1;
                        if (orders.length === 0) {
                            $('.no-records-found').show();
                            $('.pagination-container').hide();
                        } else {
                            $('.no-records-found').hide();
                            $('.pagination-container').show().html(pagination);
                        }

                        $.each(orders, function(index, order) {
                            var firstLetter = order.name ? order.name.charAt(0).toUpperCase() : 'C';
                            var isSettled = (order.payment_status === 'Paid' && order.status === 'delivered');
                            var row = `
                                <tr>
                                    <td class="text-muted fw-semibold">${serialNumber++}</td>
                                    <td>
                                        <a href="/admin/show-order/${order.id}" class="fw-bold text-decoration-none">
                                            <span class="badge bg-label-primary px-2 py-1">
                                                <i class="ti ti-tag ti-xs me-1"></i>#${order.order_number}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initial rounded-circle bg-label-secondary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                ${firstLetter}
                                            </div>
                                            <span class="fw-semibold text-dark">${order.name}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center gap-1 text-muted">
                                            <i class="ti ti-phone ti-xs text-primary"></i>
                                            <span>${order.mobile}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-secondary rounded-pill px-3 py-1 fw-semibold">
                                            ${order.total_qty} pcs
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex align-items-center gap-1 Client_table_action_area">
                                            <a href="/admin/show-order/${order.id}" class="btn btn-sm btn-outline-primary px-2 py-1 Client_table_action_icon" title="View Order">
                                                <i class="ti ti-eye ti-xs"></i>
                                            </a>
                                            ${!isSettled ? `
                                                <button class="btn btn-sm btn-outline-secondary px-2 py-1 Client_table_action_icon" onclick="window.location='/admin/edit-order/${order.id}'" title="Edit Order">
                                                    <i class="ti ti-pencil ti-xs"></i>
                                                </button>
                                                <div class="btn-group dropstart order_list_action_menu_dropmenu">
                                                    <button type="button" class="btn btn-sm btn-outline-warning px-2 py-1 dropdown-toggle Client_table_action_icon" data-bs-toggle="dropdown" aria-expanded="false" data-order_id="${order.id}">
                                                        <i class="ti ti-layout-grid ti-xs"></i>
                                                    </button>
                                                    <ul class="dropdown-menu shadow border-0 py-1">
                                                        <li>
                                                            <a class="dropdown-item set_ord_btn py-2 text-warning d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#SettleOrder" data-order_id="${order.id}">
                                                                <i class="ti ti-cash"></i> Settle & Deliver
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            ` : ''}
                                            <button class="btn btn-sm btn-outline-info px-2 py-1 Client_table_action_icon rcp_btn" data-order_id="${order.id}" title="Print Receipt & Tags">
                                                <i class="ti ti-printer ti-xs"></i>
                                            </button>
                                            ${!isSettled ? `
                                                <button class="btn btn-sm btn-outline-danger px-2 py-1 Client_table_action_icon delete_order_btn" data-id="${order.id}" data-bs-toggle="modal" data-bs-target="#delete_order" title="Delete Order">
                                                    <i class="ti ti-trash ti-xs"></i>
                                                </button>
                                            ` : ''}
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                        attachEventHandlers();
                    }
                });
            });

            function attachEventHandlers() {
                $('.delete_order_btn').off('click').on('click', function() {
                    var orderId = $(this).data('id');
                    $('#order_del_id').val(orderId);
                    $('#delete_order').modal('show');
                });

                $('#confirm_delete').off('click').on('click', function() {
                    var formData = $('#deleteOrderForm').serialize();
                    var orderId = $('#order_del_id').val();

                    $.ajax({
                        url: '/admin/delete-order/' + orderId,
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            $('#delete_order').modal('hide');
                            window.location.reload();
                        },
                        error: function(xhr) {
                            $('#delete_order').modal('hide');
                        }
                    });
                });

                $('.rcp_btn').off('click').on('click', function() {
                    var id = $(this).data('order_id');
                    $('#printReceipt').attr('href', '/admin/receipt/' + id);
                    $('#printTags').attr('href', '/admin/tagslist/' + id);
                    $('#yes').modal('show');
                });

                $('#SettleOrder').off('show.bs.modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var orderId = button.data('order_id');
                    var modal = $(this);
                    modal.attr('data-order-id', orderId);
                    modal.data('order-id', orderId);
                });
            }

            attachEventHandlers();

            $('#settleAndDeliverButton').off('click').on('click', function() {
                var modal = $('#SettleOrder');
                var orderId = modal.data('order-id');
                var paymentOption = $('input[name="paymentOption"]:checked').val();

                if (!paymentOption) {
                    $('#paymentError').text('Please select a payment option.');
                    return;
                }

                $.ajax({
                    url: '/admin/settle-and-deliver-order/' + orderId,
                    method: 'POST',
                    data: {
                        paymentType: paymentOption,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        modal.modal('hide');
                        window.location.href = '{{ route('invoice') }}';
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    });
</script>
@endsection
