@extends('backend.layouts.app')
@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl">

        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1F446E;">
                    <i class="ti ti-chart-pie-2 me-2"></i>Financial & Order Analytics
                </h4>
                <p class="text-muted mb-0 small">Real-time revenue monitoring, tax calculations, and customer order breakdowns.</p>
            </div>
            <div>
                <button type="button" class="btn btn-outline-success btn-sm d-flex align-items-center gap-2 shadow-sm" id="downloadExcel">
                    <i class="ti ti-file-spreadsheet fs-5"></i>
                    <span>Export to Excel</span>
                </button>
            </div>
        </div>

        <!-- 6 KPI Stat Cards Grid -->
        <div class="row g-3 g-md-4 mb-4">
            <!-- Total Orders -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-primary text-primary">
                                <i class="ti ti-package"></i>
                            </div>
                            <span class="badge bg-label-primary rounded-pill small">Volume</span>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #1F446E;" id="totalOrders">0</h3>
                        <p class="text-muted small mb-0">Total Orders Registered</p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-success text-success">
                                <i class="ti ti-circle-check"></i>
                            </div>
                            <span class="badge bg-label-success rounded-pill small">Delivered</span>
                        </div>
                        <h3 class="fw-bold mb-1 text-success" id="deliveredOrders">0</h3>
                        <p class="text-muted small mb-0">Completed & Delivered</p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-warning text-warning">
                                <i class="ti ti-clock-hour-4"></i>
                            </div>
                            <span class="badge bg-label-warning rounded-pill small">In Progress</span>
                        </div>
                        <h3 class="fw-bold mb-1 text-warning" id="pendingOrders">0</h3>
                        <p class="text-muted small mb-0">Pending Processing</p>
                    </div>
                </div>
            </div>

            <!-- Total Gross Revenue -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-info text-info">
                                <i class="ti ti-currency-rupee"></i>
                            </div>
                            <span class="badge bg-label-info rounded-pill small">Gross</span>
                        </div>
                        <h3 class="fw-bold mb-1 text-info" id="totalOrdersAmount">₹ 0.00</h3>
                        <p class="text-muted small mb-0">Total Order Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Tax Amount (GST 18%) -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-secondary text-secondary">
                                <i class="ti ti-receipt-tax"></i>
                            </div>
                            <span class="badge bg-label-secondary rounded-pill small">GST 18%</span>
                        </div>
                        <h3 class="fw-bold mb-1 text-secondary" id="taxAmount">₹ 0.00</h3>
                        <p class="text-muted small mb-0">Estimated Tax Collected</p>
                    </div>
                </div>
            </div>

            <!-- Taxable Amount -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="stat-icon bg-label-dark text-dark">
                                <i class="ti ti-wallet"></i>
                            </div>
                            <span class="badge bg-label-dark rounded-pill small">Net</span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark" id="grossTotal">₹ 0.00</h3>
                        <p class="text-muted small mb-0">Net Taxable Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Orders Table Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-3">
                        <h5 class="card-title mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem; color: #1F446E;">
                            <i class="ti ti-users text-primary"></i> Customer Breakdown
                        </h5>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-search text-muted"></i></span>
                                    <input type="search" class="form-control border-start-0 ps-0" placeholder="Search orders..." id="invoiceSearch">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <select id="monthDropdown" class="form-select form-select-sm">
                                    <option value="">All Months</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <input type="text" class="form-control form-control-sm" id="startDate" placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                            <div class="col-6 col-lg-3">
                                <input type="text" class="form-control form-control-sm" id="endDate" placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table align-middle" id="ordersTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>Tax (18%)</th>
                                <th>Taxable Amount</th>
                            </tr>
                        </thead>
                        <tbody id="ordersData">
                            <!-- Populated dynamically via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div id="noDataMessage" class="empty-state-box" style="display: none;">
                    <div class="empty-icon text-muted">
                        <i class="ti ti-filter-off"></i>
                    </div>
                    <h5>No Data Found</h5>
                    <p>There are no customer orders matching the selected filter criteria.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchFilteredData() {
            var search = $('#invoiceSearch').val();
            var month = $('#monthDropdown').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            $.ajax({
                url: '{{ route("analytics.filter") }}',
                method: 'GET',
                data: {
                    search: search,
                    month: month,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function (response) {
                    $('#totalOrders').text(response.totalOrders);
                    $('#pendingOrders').text(response.pendingOrders);
                    $('#deliveredOrders').text(response.deliveredOrders);
                    $('#totalOrdersAmount').text('₹ ' + response.totalOrdersAmount.toFixed(2));
                    $('#taxAmount').text('₹ ' + response.taxAmount.toFixed(2));
                    $('#grossTotal').text('₹ ' + response.grossTotal.toFixed(2));

                    $('#ordersData').html('');
                    if (response.orders && response.orders.length > 0) {
                        $('#noDataMessage').hide();
                        $.each(response.orders, function (index, order) {
                            var statusBadge = '';
                            if (order.status === 'pending') {
                                statusBadge = '<span class="badge-status badge-status-pending"><i class="ti ti-clock ti-xs"></i> Pending</span>';
                            } else if (order.status === 'delivered') {
                                statusBadge = '<span class="badge-status badge-status-delivered"><i class="ti ti-check ti-xs"></i> Delivered</span>';
                            } else {
                                statusBadge = '<span class="badge bg-label-secondary rounded-pill">' + order.status + '</span>';
                            }

                            let totalAmount = Number(order.total_amount).toFixed(2);
                            let taxVal = order.total_amount ? ((order.total_amount) - (Number(order.total_amount) / 1.18)).toFixed(2) : '0.00';
                            let taxableVal = order.total_amount ? (Number(order.total_amount) / 1.18).toFixed(2) : '0.00';

                            $('#ordersData').append(`
                                <tr>
                                    <td class="text-muted fw-semibold">${index + 1}</td>
                                    <td>
                                        <a href="/admin/show-order/${order.id}" class="fw-bold text-decoration-none">
                                            <span class="badge bg-label-primary px-2 py-1">
                                                <i class="ti ti-tag ti-xs me-1"></i>#${order.order_number}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initial rounded-circle bg-label-secondary text-primary fw-bold" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                                ${order.name ? order.name.charAt(0).toUpperCase() : 'C'}
                                            </div>
                                            <span class="fw-medium text-dark">${order.name}</span>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">${order.order_date}</span></td>
                                    <td>${statusBadge}</td>
                                    <td><span class="fw-bold text-dark">₹ ${totalAmount}</span></td>
                                    <td><span class="text-muted">₹ ${taxVal}</span></td>
                                    <td><span class="fw-semibold text-primary">₹ ${taxableVal}</span></td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#noDataMessage').show();
                    }
                },
                error: function (error) {
                    console.error('Error fetching analytics data:', error);
                }
            });
        }

        $('#invoiceSearch, #monthDropdown, #startDate, #endDate').on('change keyup', function () {
            fetchFilteredData();
        });

        fetchFilteredData();

        $('#downloadExcel').click(function () {
            let table = document.getElementById("ordersTable");
            let tableClone = table.cloneNode(true);
            let rows = tableClone.querySelectorAll("tr");

            rows.forEach(row => {
                let cells = row.querySelectorAll("td, th");
                if (cells.length >= 7) {
                    cells[6].remove();
                    cells[7].remove();
                }
            });

            let totalAmountSum = 0;
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll("td");
                if (cells.length > 5) {
                    const totalAmountCell = cells[5];
                    let totalAmount = totalAmountCell ? totalAmountCell.innerText.trim() : "0";
                    totalAmount = totalAmount.replace(/[^\d.-]/g, "");
                    if (!isNaN(totalAmount) && totalAmount !== "") {
                        totalAmount = parseFloat(totalAmount);
                        totalAmountSum += totalAmount;
                    }
                }
            });

            let newRow = tableClone.insertRow();
            for (let i = 0; i < 6; i++) {
                if (i === 4) {
                    newRow.insertCell(i).innerText = "Total Amount";
                } else if (i === 5) {
                    let totalCell = newRow.insertCell(i);
                    totalCell.innerText = "₹ " + totalAmountSum.toFixed(2);
                    totalCell.style.fontWeight = "bold";
                } else {
                    newRow.insertCell(i).innerText = "";
                }
            }

            let wb = XLSX.utils.book_new();
            let ws = XLSX.utils.table_to_sheet(tableClone, { raw: true });
            XLSX.utils.book_append_sheet(wb, ws, "Orders Data");
            XLSX.writeFile(wb, "WashFlow_Analytics_Orders.xlsx");
        });
    });
</script>
@endsection
