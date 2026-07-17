<div class="container-fluid nav-bar p-0 bg-dark">
    <div class="container p-lg-0">
        <div class="row gx-0 py-2 align-items-center">
            <div class="col-6">
                <ul class="nav">
                    @foreach($nav->take(intval($nav->count() / 2)) as $n)
                        <li class="nav-item nav-link py-0 ps-0">
                            <a href="{{ route($n->route) }}"
                               class="ps-0 nav-link text-white {{ request()->routeIs($n->route) ? 'active' : '' }}">
                                {{ $n->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6">
                <ul class="nav justify-content-end">
                    @foreach($nav->skip(intval($nav->count() / 2)) as $n)
                        <li class="nav-item nav-link py-0 pe-0">
                            <a href="{{ route($n->route) }}"
                               class="pe-0 nav-link text-white {{ request()->routeIs($n->route) ? 'active' : '' }}">
                                {{ $n->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row gx-0 py-2 align-items-center">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a href="#" class="navbar-brand">
                        <h2 class="text-white m-0"><i class="fas fa-shopping-bag text-primary me-2"></i>TechStore</h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <input type="search" name="search" class="form-control px-3"
                           placeholder="Search products..." value="">
                    <button type="submit" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2">
                        <i class="fa fa-search text-primary"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <nav class="navbar navbar-expand-lg navbar-light mt-2">
                    <a href="" class="nav-link navbar-brand d-block d-lg-none">
                        <h2 class="text-white m-0"><i class="fas fa-shopping-bag text-primary me-2"></i>TechStore</h2>
                    </a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars fa-1x text-white"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0 align-items-center">
                            @if(session('user'))
                                <div class="dropdown me-3">
                                    <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                                        {{ session('user')['first_name'] }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                        <li><a class="dropdown-item" href=" {{ route('orders.index') }}">My Orders</a></li>
                                        @if(session('user')['role'] == 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login.store') }}" class="text-white nav-item nav-link me-2 fw-normal {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                            @endif
                            <a href="{{ route('cart.index') }}" class="text-white d-flex align-items-center">
                                <div class="position-relative">
                                <span class="rounded-circle btn-md-square border border-white d-flex align-items-center justify-content-center">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                                          style="font-size: 10px;">
                                    {{ session('cart_count') ?? 0 }}
                                </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</div>
