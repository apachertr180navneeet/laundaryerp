@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-file-invoice text-primary"></i> Tax Invoice
                </h4>
                <p class="text-muted mb-0 small">Order #{{ $order->order_number ?? '' }} · Official GST billing statement</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a type="button" class="btn btn-outline-secondary btn-sm" id="backButton">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
                <a class="btn btn-outline-primary btn-sm" href="{{ url('/admin/download-invoice/' . $order->id) }}">
                    <i class="ti ti-download me-1"></i> Download PDF
                </a>
                <a class="btn btn-primary btn-sm" href="{{ url('/admin/invoice-print/' . $order->id) }}" target="_blank">
                    <i class="ti ti-printer me-1"></i> Print Invoice
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        @include('admin.invoiceDetail')
                        <input type="hidden" id="referrerUrl" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var referrer = document.referrer;
        var referrerInput = document.getElementById('referrerUrl');
        if (referrerInput) {
            referrerInput.value = referrer;
        }

        var backBtn = document.getElementById('backButton');
        if (backBtn) {
            backBtn.addEventListener('click', function() {
                var ref = referrerInput ? referrerInput.value : '';
                if (ref && ref.includes('/admin/view-order')) {
                    window.location.href = ref;
                } else {
                    window.location.href = "{{ url('/admin/invoice') }}";
                }
            });
        }
    });
</script>
@endsection
