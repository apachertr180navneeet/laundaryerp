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
                    <i class="ti ti-users me-2"></i>Client Management
                </h4>
                <p class="text-muted mb-0 small">Register and manage laundry customers, contact numbers, and history.</p>
            </div>
            <div>
                <span class="badge bg-label-primary px-3 py-2 rounded-pill fs-7 fw-semibold">
                    <i class="ti ti-user-check me-1"></i> Total: {{ $clients->total() }} Clients
                </span>
            </div>
        </div>

        <!-- Add Client Card -->
        <div class="card mb-4">
            <div class="card-header pb-2 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-user-plus text-primary"></i> Add New Client
                </h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('add.client') }}" method="post" enctype="multipart/form-data" id="add_client_form">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <!-- Client Name -->
                        <div class="col-md-5 col-12">
                            <label for="add_client_name" class="form-label fw-semibold small text-muted">Client Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-user text-muted"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="e.g. Rahul Sharma" id="add_client_name" value="{{ old('name') }}" pattern="[A-Za-z\s]+" title="Please enter only alphabetic characters and spaces." oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                            </div>
                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Client Mobile -->
                        <div class="col-md-4 col-12">
                            <label for="add_client_mobile" class="form-label fw-semibold small text-muted">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-phone text-muted"></i></span>
                                <input type="text" name="mobile" class="form-control border-start-0 ps-0" id="add_client_mobile" placeholder="e.g. 9876543210" maxlength="10" value="{{ old('mobile') }}" pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" required>
                            </div>
                            @error('mobile')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-3 col-12">
                            <button type="submit" class="btn btn_1F446E_hp w-100 d-flex align-items-center justify-content-center gap-2" id="add_save_client">
                                <i class="ti ti-device-floppy"></i> Save Client
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Client Directory Table Card -->
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                    <i class="ti ti-address-book text-primary"></i> Client Directory
                </h5>
                <div style="min-width: 260px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="search" id="clientSearch" class="form-control border-start-0 ps-0" placeholder="Search by name or phone...">
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 70px;">S. No.</th>
                                <th>Client Profile</th>
                                <th>Mobile Number</th>
                                <th class="text-end" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $serialNumber = ($clients->currentPage() - 1) * $clients->perPage() + 1;
                            @endphp
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="text-muted fw-semibold">{{ $serialNumber++ }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initial rounded-circle bg-label-primary text-primary fw-bold" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 13px;">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block lh-1">{{ $client->name }}</span>
                                                <small class="text-muted">Registered Client</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center gap-1 text-muted">
                                            <i class="ti ti-phone ti-xs text-primary"></i>
                                            <span class="fw-medium text-dark">{{ $client->mobile }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <button class="btn btn-sm btn-outline-primary px-2 py-1 edit_client_btn"
                                                data-id="{{ $client->id }}"
                                                data-name="{{ $client->name }}"
                                                data-mobile="{{ $client->mobile }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit_client"
                                                title="Edit Client">
                                                <i class="ti ti-pencil ti-xs"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger px-2 py-1 delete_client_btn"
                                                data-id="{{ $client->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete_client"
                                                title="Delete Client">
                                                <i class="ti ti-trash ti-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="no-records-found">
                    <i class="ti ti-search-off fs-2 d-block mb-2 text-muted"></i>
                    <span>No clients found matching your search.</span>
                </div>

                @if ($clients->count() > 0)
                    <div class="pagination-container p-3 border-top">
                        {{ $clients->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Edit Client Modal -->
<div class="modal fade" id="edit_client" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="editClientModalLabel" style="color: #1F446E;">
                    <i class="ti ti-user-edit me-2"></i>Edit Client Information
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editclientform" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="client_id" name="id" value="" />
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_client_name" class="form-label fw-semibold small text-muted">Client Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="ti ti-user text-muted"></i></span>
                            <input type="text" name="name" id="edit_client_name" class="form-control client_name"
                                placeholder="Enter client name" value="" pattern="[A-Za-z\s]+"
                                title="Please enter only alphabetic characters."
                                oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                        </div>
                        <span id="edit_name_error" class="text-danger small mt-1 d-block"></span>
                    </div>
                    <div class="mb-2">
                        <label for="edit_client_mobile" class="form-label fw-semibold small text-muted">Client Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="ti ti-phone text-muted"></i></span>
                            <input type="text" name="mobile" id="edit_client_mobile"
                                class="form-control client_mobile" placeholder="Enter mobile number" maxlength="10" required>
                        </div>
                        <span id="edit_mobile_error" class="text-danger small mt-1 d-block"></span>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn_1F446E_hp" id="edit_save_client">
                        <i class="ti ti-check me-1"></i> Update Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Client Modal -->
<div class="modal fade" id="delete_client" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-danger" id="deleteClientModalLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Confirm Client Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar avatar-lg rounded-circle bg-label-danger mx-auto mb-3" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="ti ti-trash"></i>
                </div>
                <h5 class="fw-semibold mb-1">Are you sure?</h5>
                <p class="text-muted small mb-0">This client will be deleted from the system. This action cannot be undone.</p>
                <form id="deleteClientForm">
                    @csrf
                    @method('GET')
                    <input type="hidden" id="client_del_id" name="client_id" value=" ">
                </form>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger px-4" id="confirm_delete">Delete Client</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#clientSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $.ajax({
                    url: '/admin/client',
                    type: 'GET',
                    data: {
                        search: searchText
                    },
                    success: function(response) {
                        var clients = response.clients;
                        var pagination = response.pagination;
                        var tbody = $('tbody');
                        tbody.empty();
                        var serialNumber = 1;

                        if (clients.length === 0) {
                            $('.no-records-found').show();
                            $('.pagination-container').hide();
                        } else {
                            $('.no-records-found').hide();
                            $('.pagination-container').show().html(pagination);
                        }

                        $.each(clients, function(index, client) {
                            var firstLetter = client.name ? client.name.charAt(0).toUpperCase() : 'C';
                            var row = `
                                <tr>
                                    <td class="text-muted fw-semibold">${serialNumber++}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initial rounded-circle bg-label-primary text-primary fw-bold" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 13px;">
                                                ${firstLetter}
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block lh-1">${client.name}</span>
                                                <small class="text-muted">Registered Client</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center gap-1 text-muted">
                                            <i class="ti ti-phone ti-xs text-primary"></i>
                                            <span class="fw-medium text-dark">${client.mobile}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <button class="btn btn-sm btn-outline-primary px-2 py-1 edit_client_btn" data-id="${client.id}" data-name="${client.name}" data-mobile="${client.mobile}" data-bs-toggle="modal" data-bs-target="#edit_client" title="Edit Client"><i class="ti ti-pencil ti-xs"></i></button>
                                            <button class="btn btn-sm btn-outline-danger px-2 py-1 delete_client_btn" data-id="${client.id}" data-bs-toggle="modal" data-bs-target="#delete_client" title="Delete Client"><i class="ti ti-trash ti-xs"></i></button>
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
                $('.edit_client_btn').off('click').on('click', function() {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var mobile = $(this).data('mobile');
                    $('.client_id').val(id);
                    $('.client_name').val(name);
                    $('.client_mobile').val(mobile);
                });

                $('.delete_client_btn').off('click').on('click', function() {
                    var id = $(this).data('id');
                    $('#client_del_id').val(id);
                    $('#delete_client').modal('show');
                });

                $('#confirm_delete').off('click').on('click', function(e) {
                    e.preventDefault();
                    var id = $('#client_del_id').val();
                    $.ajax({
                        type: 'GET',
                        url: '/admin/delete-client/' + id,
                        data: $('#deleteClientForm').serialize(),
                        success: function(response) {
                            $('#delete_client').modal('hide');
                            window.location.reload();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            }

            attachEventHandlers();

            $('#editclientform').on('submit', function(event) {
                event.preventDefault();

                var id = $('.client_id').val();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '/admin/edit-client/' + id,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#edit_client').modal('hide');
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    });
</script>
@endsection
