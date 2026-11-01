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
                    <i class="ti ti-tags me-2"></i>Garment & Item Price Catalog
                </h4>
                <p class="text-muted mb-0 small">Manage individual garment pricing mapped across services and categories.</p>
            </div>
            <div>
                <a href="{{ route('add.items') }}" class="btn btn_1F446E_hp btn-sm d-flex align-items-center gap-1 shadow-sm">
                    <i class="ti ti-plus ti-xs"></i>
                    <span>Add New Item</span>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-list text-primary"></i> Catalog Items ({{ $items->total() }})
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Service</th>
                                <th>Unit Price</th>
                                <th class="text-end" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($items->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="ti ti-tags-off fs-2 d-block mb-2"></i>
                                        No items currently added in the catalog.
                                    </td>
                                </tr>
                            @else
                                @php
                                    $serialNumber = ($items->currentPage() - 1) * $items->perPage() + 1;
                                @endphp
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="text-muted fw-semibold">{{ $serialNumber++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-initial rounded-circle bg-label-primary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                                    <i class="ti ti-shirt"></i>
                                                </div>
                                                <span class="fw-semibold text-dark">{{ $item->item_name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-info rounded-pill px-2 py-1">
                                                {{ $item->category }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-secondary rounded-pill px-2 py-1">
                                                {{ $item->service }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">₹{{ number_format((float)$item->price, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ url('/admin/edit-items/' . $item->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1" title="Edit Item">
                                                <i class="ti ti-pencil ti-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($items->count() > 0)
                    <div class="pagination-container p-3 border-top">
                        {{ $items->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
