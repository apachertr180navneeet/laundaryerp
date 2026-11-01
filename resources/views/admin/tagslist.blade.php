@extends('backend.layouts.app')

@section('content')
<style>
    .tag-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }
    .tag-card {
        background: #fff;
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
        transition: all 0.2s ease;
        position: relative;
    }
    .tag-card:hover {
        border-color: #1F446E;
        box-shadow: 0 4px 12px rgba(31, 68, 110, 0.08);
    }
    .tag-brand {
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 700;
        color: #64748b;
    }
    .tag-customer {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        text-transform: capitalize;
        margin-bottom: 4px;
    }
    .tag-order-num {
        font-size: 18px;
        font-weight: 800;
        color: #1F446E;
        font-family: monospace;
        letter-spacing: 0.5px;
    }
    .tag-delivery {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }
    .tag-total-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 12px;
        padding: 2px 10px;
        border-radius: 12px;
        margin: 6px 0;
    }
    .tag-service-pill {
        display: inline-block;
        background: #1F446E;
        color: #ffffff;
        font-weight: 700;
        font-size: 13px;
        padding: 4px 14px;
        border-radius: 6px;
        margin: 6px 0;
        text-transform: uppercase;
    }
    .tag-item-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0;
    }
</style>

<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-tags text-primary"></i> Garment Tags
                </h4>
                <p class="text-muted mb-0 small">Order #{{ $order->order_number }} · Printable barcode & garment identification tags</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ url('/admin/view-order') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Orders
                </a>
                <a class="btn btn-primary btn-sm" href="{{ url('/admin/print-taglist/' . $order->id) }}" target="_blank">
                    <i class="ti ti-printer me-1"></i> Print All Tags
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="tag-grid">
                    @foreach ($order->orderItems as $orderItem)
                        @php
                            $service = $orderItem->operation_id;
                        @endphp

                        @if($orderItem->Item->name == 'Shoe' || $orderItem->Item->name == 'Gloves' || $orderItem->Item->name == 'Socks/Stocking Pair'|| $orderItem->Item->name == 'Slip on')
                            @for ($i = 0; $i < $orderItem->quantity * 2; $i++)
                                <div class="tag-card">
                                    <div class="tag-brand">WashFlow ERP</div>
                                    <div class="tag-customer">{{ $order->user->name }}</div>
                                    <div class="tag-order-num">{{ $order->order_number }}</div>
                                    <div class="tag-delivery"><i class="ti ti-calendar me-1"></i>{{ $order->delivery_date }}</div>
                                    <div><span class="tag-total-badge">Total: {{ $subTotalqty }}</span></div>
                                    <div><span class="tag-service-pill">{{ $service }}</span></div>
                                    <p class="tag-item-name">{{ $orderItem->Item->name }} ({{ $i + 1 }}/{{ $orderItem->quantity * 2 }})</p>
                                </div>
                            @endfor
                        @elseif($orderItem->Item->name == 'Laundry By Weight')
                            @php
                                $lundaryItems = DB::table('lundary_order_item')
                                    ->join('items', 'lundary_order_item.ProductName', '=', 'items.id')
                                    ->join('categories', 'lundary_order_item.ProductCategroyId', '=', 'categories.id')
                                    ->select('items.name as item_name', 'categories.name as category_name', 'lundary_order_item.ProductQty as ProductQty')
                                    ->where('lundary_order_item.order_item_id', $order->id)
                                    ->get();
                            @endphp

                            @foreach ($lundaryItems as $lundaryItem)
                                @for ($i = 0; $i < $lundaryItem->ProductQty; $i++)
                                    <div class="tag-card">
                                        <div class="tag-brand">WashFlow ERP</div>
                                        <div class="tag-customer">{{ $order->user->name }}</div>
                                        <div class="tag-order-num">{{ $order->order_number }}</div>
                                        <div class="tag-delivery"><i class="ti ti-calendar me-1"></i>{{ $order->delivery_date }}</div>
                                        <div><span class="tag-total-badge">Total: {{ $subTotalqty }}</span></div>
                                        <div><span class="tag-service-pill">{{ $service }}</span></div>
                                        <p class="tag-item-name">{{ $lundaryItem->item_name }}</p>
                                    </div>
                                @endfor
                            @endforeach
                        @else
                            @for ($i = 0; $i < $orderItem->quantity; $i++)
                                <div class="tag-card">
                                    <div class="tag-brand">WashFlow ERP</div>
                                    <div class="tag-customer">{{ $order->user->name }}</div>
                                    <div class="tag-order-num">{{ $order->order_number }}</div>
                                    <div class="tag-delivery"><i class="ti ti-calendar me-1"></i>{{ $order->delivery_date }}</div>
                                    <div><span class="tag-total-badge">Total: {{ $subTotalqty }}</span></div>
                                    <div><span class="tag-service-pill">{{ $service }}</span></div>
                                    <p class="tag-item-name">{{ $orderItem->Item->name }} ({{ $i + 1 }}/{{ $orderItem->quantity }})</p>
                                </div>
                            @endfor
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
