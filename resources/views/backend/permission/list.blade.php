@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-key text-primary"></i> Permissions Management
                </h4>
                <p class="text-muted mb-0 small">Overview of system privileges and capability gates</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('permission.add') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus me-1"></i> Create Permission
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive text-nowrap">
                    <table id="myTable" class="table display no-wrap table-hover modern-table" width="100%">
                        <thead class="table-light">
                            <tr>
                                <th>Permission Name</th>
                                <th>Guard Name</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($list) && count($list) > 0)
                                @foreach ($list as $row)
                                <tr>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $row->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">{{ $row->guard_name }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $row->created_at }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No permissions found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
