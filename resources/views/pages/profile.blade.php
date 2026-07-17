@extends('layouts.layout')

@section('Title', 'Profile')

@section('content')

    @include('fixed.page-header', [
        'title' => 'My Profile',
        'breadcrumbs' => ['Profile' => '#']
    ])

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4">

                <!-- Left side - User info -->
                <div class="col-lg-4">
                    <!-- Profile Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width:80px; height:80px; font-size:32px; color:white;">
                                    {{ strtoupper(substr(session('user')['first_name'], 0, 1)) }}
                                </div>
                                <h5 class="fw-bold">{{ session('user')['first_name'] }} {{ session('user')['last_name'] }}</h5>
                                <p class="text-muted mb-0">{{ session('user')['email'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Profile Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Update Profile</h5>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-warning">{{ $errors->first() }}</div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">First Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                           value="{{ $user->first_name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                           value="{{ $user->last_name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ $user->email }}">
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill w-100">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Change Password</h5>
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Current Password</label>
                                    <input type="password" name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">New Password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-outline-primary rounded-pill w-100">
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right side - Order history -->
                <div class="col-lg-8">
                    <!-- Add Address Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">My Addresses</h5>
                                <button class="btn btn-primary rounded-pill px-4" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#add-address-form">
                                    <i class="fas fa-plus me-2"></i> Add Address
                                </button>
                            </div>
                            @if(session('address_success'))
                                <div class="alert alert-success">{{ session('address_success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-warning">{{ $errors->first() }}</div>
                            @endif

                            {{-- Forma za dodavanje - sakrivena po defaultu --}}
                            <div class="collapse mb-4" id="add-address-form">
                                <div class="border rounded p-3">
                                    <h6 class="fw-bold mb-3">New Address</h6>
                                    <form action="{{ route('address.store') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Label <span class="text-muted small">(optional)</span></label>
                                                <input type="text" name="label" class="form-control"
                                                       value="{{ old('label') }}" placeholder="e.g. Home, Work...">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Address</label>
                                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                                       value="{{ old('address') }}" placeholder="Street address" required>
                                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                                       value="{{ old('city') }}" placeholder="City" required>
                                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Country</label>
                                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                                       value="{{ old('country') }}" placeholder="Country" required>
                                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Phone Number</label>
                                                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                                       value="{{ old('phone_number') }}" placeholder="Phone number" required>
                                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1">
                                                    <label class="form-check-label fw-bold" for="is_default">Set as default</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                    <i class="fas fa-save me-2"></i> Save Address
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Prikaz postojecih adresa --}}
                            @if($user->addresses->count() > 0)
                                @foreach($user->addresses as $address)
                                    <div class="border rounded p-3 mb-3">
                                        {{-- Prikaz adrese --}}
                                        <div id="view-{{ $address->id }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    @if($address->label)
                                                        <span class="fw-bold">{{ $address->label }}</span> —
                                                    @endif
                                                    {{ $address->address }}, {{ $address->city }}, {{ $address->country }}
                                                    <br>
                                                    <small class="text-muted">{{ $address->phone_number }}</small>
                                                    @if($address->is_default)
                                                        <span class="badge bg-primary ms-2">Default</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-warning rounded-pill"
                                                            onclick="toggleEdit({{ $address->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('address.destroy', $address->id) }}" method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this address?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Edit forma - sakrivena po defaultu --}}
                                        <div id="edit-{{ $address->id }}" class="d-none mt-3">
                                            <form action="{{ route('address.update', $address->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Label <span class="text-muted small">(optional)</span></label>
                                                        <input type="text" name="label" class="form-control"
                                                               value="{{ $address->label }}" placeholder="e.g. Home, Work...">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Address</label>
                                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                                               value="{{ $address->address }}" placeholder="Street address" required>
                                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">City</label>
                                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                                               value="{{ $address->city }}" placeholder="City" required>
                                                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Country</label>
                                                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                                               value="{{ $address->country }}" placeholder="Country" required>
                                                        @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Phone Number</label>
                                                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                                               value="{{ $address->phone_number }}" placeholder="Phone number" required>
                                                        @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-end">
                                                        <div class="form-check mb-2">
{{--                                                            <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1">--}}
{{--                                                            <label class="form-check-label fw-bold" for="is_default">Set as default</label>--}}
                                                            <input class="form-check-input" type="checkbox" name="is_default"
                                                                   id="edit_default_{{ $address->id }}" value="1"
                                                                {{ $address->is_default ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="edit_default_{{ $address->id }}">Set as default</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex gap-2">
                                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">
                                                            <i class="fas fa-save me-1"></i> Save
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                                onclick="toggleEdit({{ $address->id }})">
                                                            Cancel
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                                    <p class="mb-0">No saved addresses yet.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Order History</h5>
                            @if($orders->count() > 0)
                                <div class="accordion" id="ordersAccordion">
                                    @foreach($orders as $order)
                                        <div class="accordion-item border mb-3 rounded shadow-sm">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed rounded" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}">
                                                    <div class="d-flex justify-content-between w-100 me-3">
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
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ $item->price }} $</td>
                                                                <td>{{ $item->price * $item->quantity }} $</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <p class="mb-1 small"><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->country }}</p>
                                                    <p class="mb-0 small"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5>No orders yet!</h5>
                                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('additional-scripts')
    <script>
        function toggleEdit(id) {
            document.getElementById('view-' + id).classList.toggle('d-none');
            document.getElementById('edit-' + id).classList.toggle('d-none');
        }
    </script>
@endsection
