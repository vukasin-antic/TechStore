@extends('admin.layouts.admin-layout')

@section('Title', 'Activity Logs')
@section('keywords', 'activity logs, admin, techstore')
@section('description', 'View and filter user activity logs in TechStore admin panel.')
@section('page-title', 'Activity Logs')

@section('content')

    <!-- Filters -->
    <div class="container-fluid shop">
        <div class="container-fluid p-3">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">All Logs</h5>
                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3" id="btn-clear-logs">
                    <i class="fas fa-trash me-2"></i>Clear All Logs
                </button>
            </div>
            <form action="{{ route('admin.logs.index') }}" method="GET">
                <div class="row g-3 justify-content-between my-3">
                    <div class="col-xl-3">
                        <div class="input-group">
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search by user or route..."/>
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="input-group">
                            <input type="search"
                                   name="route"
                                   class="form-control"
                                   value="{{ request('route') }}"
                                   placeholder="Filter by route..."/>
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <input type="date" name="date_from" class="form-control select-fixed"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-xl-3">
                        <input type="date" name="date_to" class="form-control select-fixed"
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12 d-flex align-items-center">
                        @if(request()->hasAny(['search', 'route', 'date_from', 'date_to']))
                            <div class="mb-1">
                                <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-times me-1"></i> Reset Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
            <table class="inventory-table">
                <thead>
                <tr>
                    <th class="text-center">User</th>
                    <th class="text-center">Route</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Query</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-center">{{ $log->user }}</td>
                        <td class="text-center"><span class="badge bg-secondary rounded-pill">{{ $log->route }}</span></td>
                        <td class="text-center">
                            @if($log->data && $log->data != '[[]]')
                                <small class="text-muted">{{ $log->data }}</small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($log->query)
                                <small class="text-muted">{{ $log->query }}</small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($log->date)->format('d M Y H:i:s') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger rounded-pill btn-delete-log"
                                    data-id="{{ $log->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No logs found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="p-3">
                {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        // delete one log
        $(document).on('click', '.btn-delete-log', function() {
            var logId = $(this).data('id');
            var row = $(this).closest('tr');

            confirmDelete('Are you sure you want to delete this log?', function() {
                $.ajax({
                    url: '/admin/logs/' + logId,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                            showToast(response.message, true);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            });
        });

        // delete all logs
        $('#btn-clear-logs').on('click', function() {
            confirmDelete('Are you sure you want to clear ALL logs? This cannot be undone!', function() {
                $.ajax({
                    url: '/admin/logs/',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            showToast(response.message, true);
                        } else {
                            showToast(response.message, false);
                        }
                    }
                });
            });
        });
    </script>
@endsection
