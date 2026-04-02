<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 bg-primary px-5 py-2 align-items-center">
        <div class="col-lg-3 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a href="" class="navbar-brand p-0">
                    <h1 class="display-5 text m-0"><i class="fas fa-shopping-bag text-secondary me-2"></i>TechStore</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary ">
                <a href="" class="navbar-brand d-block d-lg-none">
                    <h1 class="display-5 text m-0"><i class="fas fa-shopping-bag text-secondary me-2"></i>TechStore</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 align-items-center">
                        @foreach($nav as $n)
                            <a href="{{ route($n->route) }}" class="nav-item nav-link {{ request()->routeIs($n->route) ? 'active' : '' }}">{{$n->name}}</a>
                        @endforeach
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
                             <a href="{{ route('login.store') }}" class="nav-item nav-link me-2 {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        @endif
                            <a href="{{ route('cart.index') }}" class="text-white me-3 d-flex align-items-center">
                            <div class="position-relative">
                                <span class="rounded-circle btn-md-square border border-white d-flex align-items-center justify-content-center">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
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
