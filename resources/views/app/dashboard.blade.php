@extends('backend.layouts.app')
@section('content')
<div class="layout-page">
  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Welcome / Hero Header -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
          <h4 class="fw-bold mb-1" style="color: #1F446E;">
            <i class="ti ti-dashboard me-2"></i>Dashboard Overview
          </h4>
          <p class="text-muted mb-0 small">
            Welcome back, <strong>{{ Auth::user()->name }}</strong>! Real-time snapshot of WashFlow ERP operations.
          </p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('clientpage') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 shadow-sm">
            <i class="ti ti-user-plus ti-xs"></i>
            <span>Add Client</span>
          </a>
          <a href="{{ route('addOrder') }}" class="btn btn_1F446E_hp btn-sm d-flex align-items-center gap-1 shadow-sm">
            <i class="ti ti-plus ti-xs"></i>
            <span>New Order</span>
          </a>
        </div>
      </div>

      <!-- 4 KPI Stat Cards Grid -->
      <div class="row g-3 g-md-4 mb-4">
        <!-- Total Clients -->
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card stat-card h-100">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon bg-label-primary text-primary">
                  <i class="ti ti-users"></i>
                </div>
                <span class="badge bg-label-primary rounded-pill small">Registered</span>
              </div>
              <h3 class="fw-bold mb-1" style="color: #1F446E;">{{ number_format($clientCounts) }}</h3>
              <p class="text-muted small mb-2">Total Clients</p>
              <div class="d-flex align-items-center justify-content-between pt-1 border-top">
                <a href="{{ route('clientpage') }}" class="small fw-semibold text-primary text-decoration-none d-flex align-items-center gap-1">
                  Manage Clients <i class="ti ti-chevron-right ti-xs"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card stat-card h-100">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon bg-label-success text-success">
                  <i class="ti ti-package"></i>
                </div>
                <span class="badge bg-label-success rounded-pill small">Lifetime</span>
              </div>
              <h3 class="fw-bold mb-1 text-success">{{ number_format($orderCounts) }}</h3>
              <p class="text-muted small mb-2">Total Orders Placed</p>
              <div class="d-flex align-items-center justify-content-between pt-1 border-top">
                <a href="{{ route('viewOrder') }}" class="small fw-semibold text-success text-decoration-none d-flex align-items-center gap-1">
                  View Order History <i class="ti ti-chevron-right ti-xs"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Today's Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card stat-card h-100">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon bg-label-info text-info">
                  <i class="ti ti-calendar-event"></i>
                </div>
                <span class="badge bg-label-info rounded-pill small">Today</span>
              </div>
              <h3 class="fw-bold mb-1 text-info">{{ number_format($todayOrderCounts) }}</h3>
              <p class="text-muted small mb-2">Today's Intake Orders</p>
              <div class="d-flex align-items-center justify-content-between pt-1 border-top">
                <span class="small text-muted">Est. Amount:</span>
                <span class="small fw-bold text-dark">₹{{ number_format($todayRevenue ?? 0, 2) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Orders (Last 10 Days) -->
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card stat-card h-100">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon bg-label-warning text-warning">
                  <i class="ti ti-clock-hour-4"></i>
                </div>
                @if($pendingOrderCounts > 0)
                  <span class="badge bg-label-warning rounded-pill small">Action Needed</span>
                @else
                  <span class="badge bg-label-success rounded-pill small">All Clear</span>
                @endif
              </div>
              <h3 class="fw-bold mb-1 text-warning">{{ number_format($pendingOrderCounts) }}</h3>
              <p class="text-muted small mb-2">10-Day Pending Orders</p>
              <div class="d-flex align-items-center justify-content-between pt-1 border-top">
                <a href="{{ route('viewOrder') }}" class="small fw-semibold text-warning text-decoration-none d-flex align-items-center gap-1">
                  Process Pending <i class="ti ti-chevron-right ti-xs"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Orders Card with Modern Tabs -->
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
          <!-- Navigation Tabs -->
          <ul class="nav nav-pills gap-2 flex-nowrap overflow-x-auto text-nowrap pb-1" id="dashboardOrderTabs" role="tablist" style="-webkit-overflow-scrolling: touch; max-width: 100%;">
            <li class="nav-item" role="presentation">
              <button class="nav-link active d-flex align-items-center gap-2" id="today-orders-tab" data-bs-toggle="pill" data-bs-target="#today-orders-pane" type="button" role="tab" aria-controls="today-orders-pane" aria-selected="true">
                <i class="ti ti-calendar-event"></i>
                <span>Today's Orders</span>
                <span class="badge bg-white text-primary rounded-pill px-2 py-0 ms-1">{{ $todayOrderCounts }}</span>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link d-flex align-items-center gap-2" id="pending-orders-tab" data-bs-toggle="pill" data-bs-target="#pending-orders-pane" type="button" role="tab" aria-controls="pending-orders-pane" aria-selected="false">
                <i class="ti ti-clock-hour-4"></i>
                <span>10-Day Pending Orders</span>
                <span class="badge bg-white text-warning rounded-pill px-2 py-0 ms-1">{{ $pendingOrderCounts }}</span>
              </button>
            </li>
          </ul>

          <!-- View All Button -->
          <div>
            <a href="{{ route('viewOrder') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
              <span>View All Orders</span>
              <i class="ti ti-arrow-right ti-xs"></i>
            </a>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="tab-content pt-0" id="dashboardOrderTabsContent">

            <!-- TAB 1: Today's Orders -->
            <div class="tab-pane fade show active" id="today-orders-pane" role="tabpanel" aria-labelledby="today-orders-tab">
              @if ($orders->isEmpty())
                <div class="empty-state-box">
                  <div class="empty-icon">
                    <i class="ti ti-shopping-cart-off"></i>
                  </div>
                  <h5>No Orders Placed Today</h5>
                  <p>There are no customer orders recorded for today yet. Start accepting garments by creating a new order.</p>
                  <a href="{{ route('addOrder') }}" class="btn btn_1F446E_hp btn-sm">
                    <i class="ti ti-plus ti-xs me-1"></i> Create First Order Today
                  </a>
                </div>
              @else
                <div class="table-responsive">
                  <table class="modern-table align-middle">
                    <thead>
                      <tr>
                        <th style="width: 60px;">#</th>
                        <th>Booking ID</th>
                        <th>Client</th>
                        <th class="text-center">Total Items</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $serialNumber = ($orders->currentPage() - 1) * $orders->perPage() + 1;
                      @endphp
                      @foreach ($orders as $order)
                        @php
                          $discount = DB::table('discounts')->where('id', $order->discount_id)->first();
                          if ($discount) {
                            $orderAmount = $order->total_price - ($order->total_price * ($discount->amount / 100));
                          } else {
                            $orderAmount = $order->total_price;
                          }
                          $statusLower = strtolower($order->status ?? 'pending');
                        @endphp
                        <tr>
                          <td class="text-muted fw-semibold">{{ $serialNumber++ }}</td>
                          <td>
                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="fw-bold text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                              <span class="badge bg-label-primary px-2 py-1">
                                <i class="ti ti-tag ti-xs me-1"></i>#{{ $order->order_number }}
                              </span>
                            </a>
                          </td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <div class="avatar-initial rounded-circle bg-label-secondary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                              </div>
                              <div>
                                <span class="fw-semibold text-dark d-block lh-1">{{ $order->user->name ?? 'Walk-in Client' }}</span>
                                @if(!empty($order->user->mobile))
                                  <small class="text-muted">{{ $order->user->mobile }}</small>
                                @endif
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <span class="badge bg-label-secondary rounded-pill px-3 py-1 fw-semibold">
                              {{ $order->total_qty }} pcs
                            </span>
                          </td>
                          <td>
                            <span class="fw-bold text-dark">₹{{ number_format($orderAmount, 2) }}</span>
                          </td>
                          <td>
                            @if($statusLower === 'delivered' || $statusLower === 'completed')
                              <span class="badge-status badge-status-delivered">
                                <i class="ti ti-check ti-xs"></i> Delivered
                              </span>
                            @elseif($statusLower === 'processing' || $statusLower === 'in progress')
                              <span class="badge-status badge-status-processing">
                                <i class="ti ti-rotate ti-xs"></i> Processing
                              </span>
                            @else
                              <span class="badge-status badge-status-pending">
                                <i class="ti ti-clock ti-xs"></i> Pending
                              </span>
                            @endif
                          </td>
                          <td class="text-end">
                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1 px-3">
                              <i class="ti ti-eye ti-xs"></i> View
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                @if ($orders->hasPages())
                  <div class="p-3 border-top d-flex justify-content-end">
                    {{ $orders->appends(['pending_page' => request('pending_page')])->links() }}
                  </div>
                @endif
              @endif
            </div>

            <!-- TAB 2: Pending Orders (Last 10 Days) -->
            <div class="tab-pane fade" id="pending-orders-pane" role="tabpanel" aria-labelledby="pending-orders-tab">
              @if ($pendingOrders->isEmpty())
                <div class="empty-state-box">
                  <div class="empty-icon text-success">
                    <i class="ti ti-circle-check"></i>
                  </div>
                  <h5 class="text-success">All Caught Up!</h5>
                  <p>There are no pending orders in the last 10 days. All orders are processed and delivered promptly.</p>
                </div>
              @else
                <div class="table-responsive">
                  <table class="modern-table align-middle">
                    <thead>
                      <tr>
                        <th style="width: 60px;">#</th>
                        <th>Booking ID</th>
                        <th>Client</th>
                        <th class="text-center">Total Items</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $serialNumberPending = ($pendingOrders->currentPage() - 1) * $pendingOrders->perPage() + 1;
                      @endphp
                      @foreach ($pendingOrders as $order)
                        @php
                          $discount = DB::table('discounts')->where('id', $order->discount_id)->first();
                          if ($discount) {
                            $pendingAmount = $order->total_price - ($order->total_price * ($discount->amount / 100));
                          } else {
                            $pendingAmount = $order->total_price;
                          }
                        @endphp
                        <tr>
                          <td class="text-muted fw-semibold">{{ $serialNumberPending++ }}</td>
                          <td>
                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="fw-bold text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                              <span class="badge bg-label-warning px-2 py-1">
                                <i class="ti ti-tag ti-xs me-1"></i>#{{ $order->order_number }}
                              </span>
                            </a>
                          </td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <div class="avatar-initial rounded-circle bg-label-secondary text-primary fw-bold" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                              </div>
                              <div>
                                <span class="fw-semibold text-dark d-block lh-1">{{ $order->user->name ?? 'Walk-in Client' }}</span>
                                @if(!empty($order->user->mobile))
                                  <small class="text-muted">{{ $order->user->mobile }}</small>
                                @endif
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <span class="badge bg-label-secondary rounded-pill px-3 py-1 fw-semibold">
                              {{ $order->total_qty }} pcs
                            </span>
                          </td>
                          <td>
                            <span class="fw-bold text-dark">₹{{ number_format($pendingAmount, 2) }}</span>
                          </td>
                          <td>
                            <span class="badge-status badge-status-pending">
                              <i class="ti ti-clock ti-xs"></i> Pending
                            </span>
                          </td>
                          <td class="text-end">
                            <a href="{{ url('/admin/show-order/' . $order->id) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1 px-3">
                              <i class="ti ti-eye ti-xs"></i> View
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                @if ($pendingOrders->hasPages())
                  <div class="p-3 border-top d-flex justify-content-end">
                    {{ $pendingOrders->appends(['today_page' => request('today_page')])->links() }}
                  </div>
                @endif
              @endif
            </div>

          </div>
        </div>
      </div>

    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
</div>
@endsection
