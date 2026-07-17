@extends('layouts.layout')

@section('Title', 'My Orders')

@section('content')

    @include('fixed.page-header', [
        'title' => 'My Orders',
        'breadcrumbs' => ['My Orders' => '#']
    ])

    <div class="container-fluid py-5">
        <div class="container py-5">
            @if($orders->count() > 0)
                <div class="accordion" id="ordersAccordion">
                    @foreach($orders as $order)
                        <div class="accordion-item border mb-3 rounded shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}">
                                    <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                        <span class="fw-bold text-primary">{{ $order->order_number }}</span>
                                        <span class="text-muted small">{{ $order->created_at->format('d M Y') }}</span>

                                        <span class="fw-bold">{{ $order->total_price }} $</span>
                                        <span class="badge rounded-pill px-3 py-2 {{ $order->status->color }}">
                                            {{ $order->status->label }}
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="order-{{ $order->id }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table mb-3">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product?->name ?? 'Deleted product' }}
                                                    @if(!$item->product || $item->product->trashed())
                                                        <span class="badge bg-secondary ms-1">No longer available</span>
                                                    @endif</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }} $</td>
                                                <td>{{ $item->price * $item->quantity }} $</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Delivery Information</h6>
                                            <p class="mb-1 small">{{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                                            <p class="mb-1 small">Phone: {{ $order->phone_number }}</p>
                                            @if($order->notes)
                                                <p class="mb-1 small">Notes: {{ $order->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @if($order->discount)
                                                <p class="text-end text-success mb-3">Congrats you used our promo code
                                                    {{ $order->promo_code }} for discount: <strong>-{{ round($order->discount_percent, 2) }}%</strong></p>
                                            @endif
                                            <h5 class="fw-bold text-primary">Total: {{ $order->total_price }} $</h5>
                                        </div>
                                    </div>
                                    @if($order->status_id === $pendingStatus->id)
                                        <div class="text-end mt-2">
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-cancel-order"
                                                    data-id="{{ $order->id }}">
                                                <i class="fas fa-times me-1"></i> Cancel Order
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4>No orders yet!</h4>
                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Please tell us why you want to cancel this order</p>
                    <textarea id="cancelReason" class="form-control" rows="4"
                              placeholder="Enter reason for cancellation..."></textarea>
                    <div id="cancelReasonError" class="text-danger small mt-1 d-none">
                        Please enter a reason for cancellation
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Keep Order</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4"
                            id="confirmCancelBtn">Cancel Order</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional-scripts')
    <script>
        var cancelOrderId;
        var cancelBtn;
        var cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));

        $(document).on('click', '.btn-cancel-order', function() {
            cancelOrderId = $(this).data('id');
            cancelBtn = $(this);
            $('#cancelReason').val('');
            $('#cancelReasonError').addClass('d-none');
            cancelModal.show();
        });

        $('#confirmCancelBtn').on('click', function() {
            var reason = $('#cancelReason').val().trim();

            if (!reason) {
                $('#cancelReasonError').removeClass('d-none');
                return;
            }

            $.ajax({
                url: '/my-orders/' + cancelOrderId + '/cancel',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'PATCH',
                    cancel_reason: reason,
                },
                success: function(response) {
                    if (response.success) {
                        cancelModal.hide();
                        cancelBtn.closest('.accordion-item').find('.badge')
                            .attr('class', 'badge rounded-pill px-3 py-2 badge-cancelled')
                            .text('Cancelled');
                        cancelBtn.closest('.text-end').remove();
                        showToast(response.message);
                    } else {
                        showToast(response.message, false);
                    }
                }
            });
        });
    </script>
@endsection
