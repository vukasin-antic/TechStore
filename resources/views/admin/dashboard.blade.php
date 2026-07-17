@extends('admin.layouts.admin-layout')

@section('Title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalOrders }}</div>
                        <div class="stat-label">Total Orders
                            <small class="text-warning mx-5">{{ $pendingOrders }} pending</small>
                        </div>

                    </div>
                    <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalProducts }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($totalRevenue, 2) }} $</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales chart: last 30 days -->
    <div class="admin-table mb-4">
        <div class="table-header">
            <h5>Sales &mdash; Last 30 Days</h5>
            <button class="btn btn-primary btn-sm rounded-pill px-3" type="button"
                    data-bs-toggle="collapse" data-bs-target="#salesDataTable"
                    aria-expanded="false" aria-controls="salesDataTable">
                View Data
            </button>
        </div>
        <div class="p-3">
            <div class="d-flex align-items-center mb-1">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;margin-right:8px;background:#2a78d6"></span>
                <span class="text-muted small fw-semibold">Revenue ($)</span>
            </div>
            <div style="position:relative;height:210px">
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="d-flex align-items-center mb-1 mt-4">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;margin-right:8px;background:#1baf7a"></span>
                <span class="text-muted small fw-semibold">Orders</span>
            </div>
            <div style="position:relative;height:170px">
                <canvas id="ordersChart"></canvas>
            </div>

            <div class="collapse mt-3" id="salesDataTable">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-end">Revenue ($)</th>
                        <th class="text-end">Orders</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($salesChart['labels'] as $i => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td class="text-end">{{ number_format($salesChart['revenue'][$i], 2) }}</td>
                            <td class="text-end">{{ $salesChart['orders'][$i] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="admin-table mb-4">
        <div class="table-header">
            <h5>Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">View All</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td><span class="text-primary fw-bold">{{ $order->order_number }}</span></td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $order->status->color }}">
                                            {{ $order->status->label }}
                                        </span>
                    </td>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No orders yet</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Logs -->
    <div class="admin-table">
        <div class="table-header">
            <h5>Recent Activity</h5>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">View All</a>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>User</th>
                <th>Route</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentLogs as $log)
                <tr>
                    <td>{{ $log->user }}</td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $log->route }}</span></td>
                    <td><small>{{ \Carbon\Carbon::parse($log->date)->format('d M H:i') }}</small></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No logs yet</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection

@section('additional-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const data = @json($salesChart);

            // Series and chrome colors, validated for contrast and CVD safety
            const t = { revenue: '#2a78d6', orders: '#1baf7a', grid: '#e9e8e4', ticks: '#6c757d', surface: '#ffffff' };
            const wash = (hex) => hex + '1a'; // ~10% opacity area fill

            function buildChart(canvasId, values, seriesKey, formatValue) {
                return new Chart(document.getElementById(canvasId), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: values,
                            borderColor: t[seriesKey],
                            backgroundColor: wash(t[seriesKey]),
                            fill: true,
                            borderWidth: 2,
                            borderJoinStyle: 'round',
                            tension: 0.3,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            pointHitRadius: 16,
                            pointHoverBackgroundColor: t[seriesKey],
                            pointHoverBorderColor: t.surface,
                            pointHoverBorderWidth: 2,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: { callbacks: { label: (ctx) => formatValue(ctx.parsed.y) } },
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { color: t.grid },
                                ticks: { color: t.ticks, maxTicksLimit: 8, maxRotation: 0 },
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: t.grid, lineWidth: 1 },
                                border: { display: false },
                                ticks: { color: t.ticks, maxTicksLimit: 5, precision: 0, callback: (v) => formatValue(v) },
                            },
                        },
                    },
                });
            }

            const formatMoney = (v) => '$' + Number(v).toLocaleString();
            const formatCount = (v) => Number(v).toLocaleString();

            buildChart('revenueChart', data.revenue, 'revenue', formatMoney);
            buildChart('ordersChart', data.orders, 'orders', formatCount);
        })();
    </script>
@endsection
