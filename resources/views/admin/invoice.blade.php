@extends('backend.layouts.app')
@section('content')
<style>
    .pagination-container {
        display: flex;
        justify-content: end;
        margin-top: 20px;
    }
    .pagination-container svg {
        width: 24px;
    }
    .pagination-container nav .justify-between {
        display: none;
    }
    #dateRangeContainer {
        display: none;
    }
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
                    <i class="ti ti-receipt me-2"></i>Invoice Management
                </h4>
                <p class="text-muted mb-0 small">Tax invoices, order billings, and spreadsheet financial exports.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="#" class="btn btn-outline-success btn-sm d-flex align-items-center gap-1 shadow-sm" id="exportButton">
                    <i class="ti ti-file-spreadsheet fs-5"></i>
                    <span>Export Invoices</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-3">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-12 col-md-4">
                        <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                            <i class="ti ti-file-invoice text-primary"></i> Generated Tax Invoices
                        </h5>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                            <!-- Hidden date range container for export -->
                            <div class="w-100 w-sm-auto mb-1" id="dateRangeContainer">
                                <input type="text" id="dateRange" class="form-control form-control-sm" placeholder="Select Export Date Range" />
                            </div>

                            <!-- Date Range Picker -->
                            <div class="w-100 w-sm-auto" style="min-width: 220px;">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-calendar text-muted"></i></span>
                                    <input type="text" id="newdateRange" class="form-control border-start-0 ps-0" placeholder="Select Date Range" />
                                </div>
                            </div>

                            <button class="btn btn-sm btn_1F446E_hp d-flex align-items-center gap-1" id="filterButton" type="button">
                                <i class="ti ti-filter ti-xs"></i>
                                <span>Load Invoices</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Invoice No.</th>
                                <th>Order Booking ID</th>
                                <th>Taxable Amount (₹)</th>
                                <th>Total Bill (₹)</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceRow">
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                        No invoices recorded for the selected range.
                                    </td>
                                </tr>
                            @else
                                @foreach ($orders as $order)
                                    @php
                                        $discount = DB::table('discounts')->where('id', $order->discount_id)->first();
                                        if ($discount) {
                                            $amount = $order->total_amount - ($order->total_amount * ($discount->amount / 100));
                                        } else {
                                            $amount = $order->total_amount;
                                        }
                                        $taxableAmount = $amount / 1.18;
                                        $statusLower = strtolower($order->status ?? 'pending');
                                    @endphp
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge bg-label-dark px-2 py-1 fw-semibold">
                                                <i class="ti ti-receipt me-1"></i>{{ $order->invoice_number }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="fw-bold text-decoration-none">
                                                <span class="badge bg-label-primary px-2 py-1">
                                                    #{{ $order->order_number }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">₹ {{ number_format($taxableAmount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark fs-6">₹ {{ number_format($amount, 2) }}</span>
                                        </td>
                                        <td>
                                            @if($statusLower === 'delivered' || $statusLower === 'completed')
                                                <span class="badge-status badge-status-delivered">
                                                    <i class="ti ti-check ti-xs"></i> {{ $order->status }}
                                                </span>
                                            @else
                                                <span class="badge-status badge-status-pending">
                                                    <i class="ti ti-clock ti-xs"></i> {{ $order->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ url('/admin/invoice/' . $order->id) }}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1 inv_btn" id="printReceipt" title="Print Tax Invoice">
                                                <i class="ti ti-printer ti-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="no-records-found">
                    <i class="ti ti-search-off fs-2 d-block mb-2 text-muted"></i>
                    <span>No invoices found for the selected dates.</span>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#newdateRange').daterangepicker({
            opens: 'left',
            maxDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        document.getElementById('filterButton').addEventListener('click', function() {
            const dateRange = document.getElementById('newdateRange').value;
            const dates = dateRange.split(' - ');
            const startDate = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
            const endDate = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');

            fetch(`{{ route('indexfilter') }}?startDate=${startDate}&endDate=${endDate}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const orders = data.orders;
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';

                orders.forEach((order, index) => {
                    const bookingId = order.order_number;
                    const taxableAmount = (order.total_amount / 1.18).toFixed(2);
                    const statusLower = (order.status || '').toLowerCase();
                    let statusHtml = '';
                    if (statusLower === 'delivered' || statusLower === 'completed') {
                        statusHtml = `<span class="badge-status badge-status-delivered"><i class="ti ti-check ti-xs"></i> ${order.status}</span>`;
                    } else {
                        statusHtml = `<span class="badge-status badge-status-pending"><i class="ti ti-clock ti-xs"></i> ${order.status}</span>`;
                    }

                    const row = `
                        <tr>
                            <td class="text-muted fw-semibold">${index + 1}</td>
                            <td>
                                <span class="badge bg-label-dark px-2 py-1 fw-semibold">
                                    <i class="ti ti-receipt me-1"></i>${order.invoice_number}
                                </span>
                            </td>
                            <td>
                                <a href="/admin/show-order/${order.id}" class="fw-bold text-decoration-none">
                                    <span class="badge bg-label-primary px-2 py-1">#${bookingId}</span>
                                </a>
                            </td>
                            <td><span class="text-muted">₹ ${taxableAmount}</span></td>
                            <td><span class="fw-bold text-dark fs-6">₹ ${Number(order.total_amount).toFixed(2)}</span></td>
                            <td>${statusHtml}</td>
                            <td class="text-end">
                                <a href="/admin/invoice/${order.id}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1 inv_btn" id="printReceipt" title="Print Tax Invoice">
                                    <i class="ti ti-printer ti-xs"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });

                if (orders.length === 0) {
                    document.querySelector('.no-records-found').style.display = 'block';
                } else {
                    document.querySelector('.no-records-found').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });

        $(document).ready(function() {
            $('#dateRange').daterangepicker({
                opens: 'left',
                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#exportButton').click(function(e) {
                e.preventDefault();
                $('#dateRangeContainer').slideToggle();
            });

            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                let dateRange = $(this).val();
                let url = '{{ url('/admin/orders/export') }}' + '?date_range=' + dateRange;
                window.location.href = url;
            });
        });
    });
</script>
@endsection
