@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-shield-check text-primary"></i> Roles Management
                </h4>
                <p class="text-muted mb-0 small">Manage user access roles and system security capabilities</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('role.add') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus me-1"></i> Create Role
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-3 p-md-4">
                <div class="table-responsive">
                    <table id="myTable" class="table display no-wrap table-hover role_datatable modern-table" width="100%">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Role Name</th>
                                <th style="width: 120px;" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extrascript')
<script type="text/javascript">
    $(function() {
        var table = $('.role_datatable').DataTable({
            processing: false,
            serverSide: true,
            scrollX: true,
            stateSave: true,
            ajax: "",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end' },
            ],
            bLengthChange: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search roles..."
            }
        });
    });
</script>
@endsection
