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
                    <i class="ti ti-credit-card me-2"></i>Payment Transactions
                </h4>
                <p class="text-muted mb-0 small">Real-time ledger of order collections, payment methods, and settlements.</p>
            </div>
            <div>
                <span class="badge bg-label-primary px-3 py-2 rounded-pill fs-7 fw-semibold">
                    <i class="ti ti-receipt me-1"></i> Total: {{ $payments->total() }} Payments
                </span>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-list text-primary"></i> Payment Records
                </h5>
                <div class="w-100 w-sm-auto flex-grow-1 flex-sm-grow-0" style="min-width: 280px;">
                    <form action="{{ route('payment') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted" id="resetSearch"></i></span>
                            <input type="search" name="search" class="form-control border-start-0 ps-0" placeholder="Search booking or amount..." id="paymentSearch" value="{{ request()->input('search') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn_1F446E_hp px-3">Search</button>
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Booking ID</th>
                                <th>Settlement Date</th>
                                <th>Payment Method</th>
                                <th>Total Amount</th>
                                <th class="text-end" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($payments->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="ti ti-credit-card-off fs-2 d-block mb-2"></i>
                                        No payment records recorded yet.
                                    </td>
                                </tr>
                            @else
                                @php
                                    $serialNumber = ($payments->currentPage() - 1) * $payments->perPage() + 1;
                                @endphp
                                @foreach ($payments as $payment)
                                    @php
                                        $typeLower = strtolower($payment->payment_type ?? '');
                                    @endphp
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $serialNumber++ }}</td>
                                        <td>
                                            <a href="{{ url('/admin/show-order/' . $payment->order_prim_id) }}" class="fw-bold text-decoration-none">
                                                <span class="badge bg-label-primary px-2 py-1">
                                                    <i class="ti ti-tag ti-xs me-1"></i>#{{ $payment->order_number }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-inline-flex align-items-center gap-1 text-muted">
                                                <i class="ti ti-calendar ti-xs text-primary"></i>
                                                <span>{{ \Carbon\Carbon::parse($payment->updated_at)->format('j F, Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($typeLower === 'cash')
                                                <span class="badge bg-label-success rounded-pill px-3 py-1">
                                                    <i class="ti ti-cash ti-xs me-1"></i> Cash
                                                </span>
                                            @else
                                                <span class="badge bg-label-info rounded-pill px-3 py-1">
                                                    <i class="ti ti-qrcode ti-xs me-1"></i> {{ $payment->payment_type ?? 'Online/UPI' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark fs-6">₹ {{ number_format((float)$payment->total_amount, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ url('/admin/show-order/' . $payment->order_prim_id) }}" class="btn btn-sm btn-outline-primary px-2 py-1" title="View Order Details">
                                                <i class="ti ti-eye ti-xs"></i>
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
                    <span>No payments found matching your search.</span>
                </div>

                @if ($payments->count() > 0)
                    <div class="pagination-container p-3 border-top">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#paymentSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                    url: '{{ route("payment") }}',
                    type: 'GET',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        var payments = response.payments;
                        var pagination = response.pagination;
                        var tbody = $('tbody');
                        tbody.empty();
                        var serialNumber = 1;

                        if (payments.length === 0) {
                            $('.no-records-found').show();
                            $('.pagination-container').hide();
                        } else {
                            $('.no-records-found').hide();
                            $('.pagination-container').show().html(pagination);
                        }

                        $.each(payments, function(index, payment) {
                            let formattedDate = new Date(payment.updated_at).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });

                            let typeBadge = '';
                            if ((payment.payment_type || '').toLowerCase() === 'cash') {
                                typeBadge = '<span class="badge bg-label-success rounded-pill px-3 py-1"><i class="ti ti-cash ti-xs me-1"></i> Cash</span>';
                            } else {
                                typeBadge = '<span class="badge bg-label-info rounded-pill px-3 py-1"><i class="ti ti-qrcode ti-xs me-1"></i> ' + (payment.payment_type || 'Online/UPI') + '</span>';
                            }

                            var row = `
                                <tr>
                                    <td class="text-muted fw-semibold">${serialNumber++}</td>
                                    <td>
                                        <a href="/admin/show-order/${payment.order_prim_id}" class="fw-bold text-decoration-none">
                                            <span class="badge bg-label-primary px-2 py-1">
                                                <i class="ti ti-tag ti-xs me-1"></i>#${payment.order_number}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center gap-1 text-muted">
                                            <i class="ti ti-calendar ti-xs text-primary"></i>
                                            <span>${formattedDate}</span>
                                        </div>
                                    </td>
                                    <td>${typeBadge}</td>
                                    <td><span class="fw-bold text-dark fs-6">₹ ${Number(payment.total_amount).toFixed(2)}</span></td>
                                    <td class="text-end">
                                        <a href="/admin/show-order/${payment.order_prim_id}" class="btn btn-sm btn-outline-primary px-2 py-1" title="View Order Details">
                                            <i class="ti ti-eye ti-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching payment data:", error);
                    }
                });
            });
        });
    });
</script>
@endsection
