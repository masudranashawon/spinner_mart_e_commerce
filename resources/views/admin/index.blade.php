@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center grid-margin flex-wrap">
    <div>
        <h4 class="mb-md-0 mb-3">Welcome to Dashboard</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <div class="input-group dashboard-date mb-md-0 d-md-none d-xl-flex mb-2 mr-2 border-0 bg-white px-3 py-2 rounded shadow-sm">
            <span class="input-group-addon bg-transparent mr-2"><i data-feather="calendar" class="text-primary"></i></span>
            <span class="font-weight-bold text-dark">{{ now()->format('d F, Y') }}</span>
        </div>
    </div>
</div>

<!-- Top 3 Cards -->
<div class="row grow">
    <!-- Total Customers -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Customers</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">{{ number_format($totalCustomers) }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-success"><span>Active</span></p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <!-- Mini Chart -->
                        <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Total Revenue</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">{{ format_price($totalRevenue, false) }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-primary"><span>Sales</span></p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Net Profit -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Net Earnings (Profit)</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-2">{{ format_price($totalProfit, false) }}</h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-success"><span>Profit</span></p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart Row -->
<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-md-3 mb-4">
                    <h6 class="card-title mb-0">Revenue Analytics (Last 30 Days)</h6>
                </div>
                <div class="flot-wrapper">
                    <div id="flotChart1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Sales & Order Stats -->
<div class="row">
    <!-- Monthly Sales Bar Chart -->

    <!-- Monthly Sales Bar Chart -->
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Monthly Sales ({{ date('Y') }})</h6>
                </div>
                <div class="monthly-sales-chart-wrapper">
                    <canvas id="monthly-sales-chart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Order Statistics -->
    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4">
                    <h6 class="card-title mb-0">Order Statistics</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <i data-feather="clock" class="text-warning icon-md mr-3"></i>
                        <h6 class="mb-0 font-weight-normal">Pending</h6>
                    </div>
                    <h5 class="mb-0 font-weight-bold">{{ $orderStats['pending'] }}</h5>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <i data-feather="loader" class="text-primary icon-md mr-3"></i>
                        <h6 class="mb-0 font-weight-normal">Processing</h6>
                    </div>
                    <h5 class="mb-0 font-weight-bold">{{ $orderStats['processing'] }}</h5>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <i data-feather="check-circle" class="text-success icon-md mr-3"></i>
                        <h6 class="mb-0 font-weight-normal">Delivered</h6>
                    </div>
                    <h5 class="mb-0 font-weight-bold">{{ $orderStats['delivered'] }}</h5>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <i data-feather="check-circle" class="text-info icon-md mr-3"></i>
                        <h6 class="mb-0 font-weight-normal">Cancelled</h6>
                    </div>
                    <h5 class="mb-0 font-weight-bold">{{ $orderStats['cancelled'] }}</h5>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i data-feather="x-circle" class="text-danger icon-md mr-3"></i>
                        <h6 class="mb-0 font-weight-normal">Returned</h6>
                    </div>
                    <h5 class="mb-0 font-weight-bold">{{ $orderStats['returned'] }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Inbox / Messages -->
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h6 class="card-title mb-0">Recent Messages</h6>
                    <a href="{{ route('admin.contact.index') }}" class="text-primary text-decoration-none small">View All</a>
                </div>
                <div class="d-flex flex-column">

                    @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.contact.index') }}" class="d-flex align-items-center border-bottom py-3 text-decoration-none">
                        <div class="mr-3">
                            <!-- User Avatar Placeholder (Initials) -->
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 14px;">
                                {{ strtoupper(substr($msg->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">{{ $msg->name }}</h6>
                                <p class="text-muted tx-12">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-muted tx-13">{{ Str::limit($msg->subject ?? $msg->message, 30) }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <p>No recent messages found.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders (Replaced Projects) -->
    <div class="col-lg-7 col-xl-8 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                    <h6 class="card-title mb-0">Recent Orders</h6>
                    <a href="{{ route('admin.order.index') }}" class="text-primary text-decoration-none small">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table-hover mb-0 table">
                        <thead class="bg-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="font-weight-bold">#{{ $order->order_number ?? $order->id }}</td>
                                <td>{{ $order->created_at->format('d M, Y') }}</td>
                                <td class="font-weight-bold">{{ format_price($order->grand_total ?? 0) }}</td>

                                <td class="text-capitalize">
                                    @switch($order->order_status)
                                    @case(\App\Enums\OrderStatusEnums::PENDING->value)
                                    <span class="badge badge-warning">Pending</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::CONFIRMED->value)
                                    <span class="badge badge-info">Confirmed</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::PROCESSING->value)
                                    <span class="badge badge-primary">Processing</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::SHIPPED->value)
                                    <span class="badge badge-secondary">Shipped</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::DELIVERED->value)
                                    <span class="badge badge-success">Delivered</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::CANCELLED->value)
                                    <span class="badge badge-danger">Cancelled</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::RETURN_REQUESTED->value)
                                    <span class="badge badge-dark">Return Requested</span>
                                    @break

                                    @case(\App\Enums\OrderStatusEnums::RETURNED->value)
                                    <span class="badge badge-light text-dark">Returned</span>
                                    @break

                                    @default
                                    <span class="badge badge-secondary">
                                        {{ str_replace('_', ' ', $order->order_status) }}
                                    </span>
                                    @endswitch
                                </td>

                                <td>
                                    <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-outline-info p-1 px-2">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No orders found yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
 $(document).ready(function() {
  'use strict';
  
  let colors = {
    primary:   "#727cf5",
    secondary: "#7987a1",
    success:   "#42b72a",
    info:      "#68afff",
    warning:   "#fbbc06",
    danger:    "#ff3366",
    light:     "#ececec",
    dark:      "#282f3a",
    muted:     "#686868"
  };

  let gridLineColor = 'rgba(77, 138, 240, .1)';

  // Dynamic Flot Chart (Last 30 Days Revenue)
  let flotChartData = @json($dailyRevenueData);
  
  if($('#flotChart1').length) {
    $.plot('#flotChart1', [{
      data: flotChartData,
      color: colors.primary
    }], {
      series: {
        shadowSize: 0,
        lines: { 
            show: true, 
            lineWidth: 2, 
            fill: true, 
            fillColor: 'rgba(114, 124, 245, 0.15)'
        }
      },
      grid: { borderColor: 'transparent', borderWidth: 1, labelMargin: 0, aboveData: false },
      yaxis: {
        show: true, color: 'rgba(0,0,0,0.06)', tickColor: gridLineColor,
        font: { size: 11, weight: '600', color: colors.muted }
      },
      xaxis: { show: false } // Hidden X axis for cleaner look
    });
  }

  // Dynamic Monthly Sales Chart (Bar Chart - Colorful)
  let monthlyData = @json($monthlySalesData);

  let barColors = [
      colors.primary, colors.info, colors.success, colors.warning, 
      colors.danger, colors.secondary, colors.primary, colors.info, 
      colors.success, colors.warning, colors.danger, colors.primary
  ];

  if($('#monthly-sales-chart').length) {
    let monthlySalesChart = document.getElementById('monthly-sales-chart').getContext('2d');
    new Chart(monthlySalesChart, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
          label: 'Revenue',
          data: monthlyData,
          backgroundColor: barColors
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: { display: false },
        scales: {
          xAxes: [{ barPercentage: .3, categoryPercentage: .6, gridLines: { display: false } }],
          yAxes: [{ gridLines: { color: gridLineColor }, ticks: { beginAtZero: true } }]
        }
      }
    });
  }

  // Mini Apex Charts
  let commonApexOptions = {
    chart: { type: "line", height: 60, sparkline: { enabled: true } },
    stroke: { width: 2, curve: "smooth" },
    markers: { size: 0 },
    tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
  };

  // Customers Chart
  if($('#apexChart1').length) {
      let opt1 = Object.assign({}, commonApexOptions, { 
          colors: [colors.primary],
          series: [{ data: [10, 20, 15, 30, 25, 40, 35] }] 
      });
      new ApexCharts(document.querySelector("#apexChart1"), opt1).render();
  }

  // Revenue Chart
  if($('#apexChart2').length) {
      let opt2 = Object.assign({}, commonApexOptions, { 
          chart: { type: "bar", height: 60, sparkline: { enabled: true } }, 
          colors: [colors.success],
          series: [{ data: [10, 20, 15, 30, 25, 40, 35] }] 
      });
      new ApexCharts(document.querySelector("#apexChart2"), opt2).render();
  }

  // Profit Chart
  if($('#apexChart3').length) {
      let opt3 = Object.assign({}, commonApexOptions, { 
          colors: [colors.info],
          series: [{ data: [5, 10, 25, 15, 35, 20, 45] }] 
      });
      new ApexCharts(document.querySelector("#apexChart3"), opt3).render();
  }
 });
 
</script>
@endpush