<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-menu"
            aria-controls="navbar-menu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        {{-- LOGO --}}
        <a href="../../.." class="navbar-brand navbar-brand-autodark me-3">
            <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOCvNa3r_hszq7pPtvOQKKYOepdqMsD5tJapqoyZoiAA&s=10"
                class="navbar-brand-image"
            >
            Ebooks
        </a>


        {{-- NAVBAR --}}
        <ul class="navbar-nav mx-auto w-50">
            @if (Auth::check() && Auth::user()->role == "admin")
            <li class="nav-item-active">
                <a href="{{ route('admin.dashboard')}}" class="nav-link">Dashboard</a>
            </li>
                {{-- route()->routeIs : mengecek apakah route saat ini sesuai dengan route yg ditentukan.
                Fungsinya untuk memberikan class active yg nantinya akan berwarna biru pd link yg sedang aktif --}}
                <li class="nav-item">
                    <a href="{{ route('admin.book-categories.index')}}" class="nav-link {{request()
                    ->routeIs('admin.book-categories.index') ? 'active' : '' }}">Kategori Buku</a>
                </li>
                  <li class="nav-item">
                   <a href="{{ route('admin.subscription.index') }}"
                    class="nav-link {{ request()->routeIs('admin.subscription.index') ? 'active' : '' }}">
                        Paket Langganan</a>
                </li>
                <li class="nav-item">
            <a href="{{ route('admin.books.index') }}"
                class="nav-link {{ request()->routeIs('admin.books.index') ? 'active' : '' }}">Buku</a>
            {{-- tambahin ini ke di code navbar --}}
        </li>


            @else
           {{-- DROPDOWN KATEGORI --}}
<div class="dropdown mt-2">
    <a
        href="#"
        class="btn btn-light dropdown-toggle pt-2 me-2"
        data-bs-toggle="dropdown"
    >
        Kategori
    </a>

    <div
        class="dropdown-menu dropdown-menu-card"
        style="min-width: 600px"
    >
        <div class="p-3">
            <div class="row g-2">
                @foreach ($categories as $category)
                    <div class="col-3">
                        <a href="{{ route('category.show', $category->id) }}"
                        class="text-decoration-none text-reset">
                            <div class="card py-2 h-100">
                                <div class="card-body p-2 text-center">
                                    {{ $category->name }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>


            {{-- SEARCH --}}
          <form method="GET" action="{{ route('search') }}" class="input-icon w-100 py-2">
            <input
                type="text"
               value="{{request('q') }}"
               name="q"
                class="form-control form-control-rounded"
                placeholder="Cari Judul, produk, buku, penulis, dll...">
                <button type="submit" class="input-icon-addon btn border-0 p-0 bg-transparent">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"></path><circle cx="10" cy="10" r="7">
                    </circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                </button>
          </form>


            {{-- KERANJANG --}}
            <div class="mt-3 ms-2">
                <i class="fa-solid fa-cart-arrow-down fs-3 text-dark"></i>
            </div>
        @endif
        </ul>


{{-- LOGIN REGISTER --}}
        
<div class="navbar-nav flex-row order-md-last ms-auto align-items-center gap-2">
    @if (Auth::check())
            <a href="{{ route('profile') }}"
            class="btn btn-light d-flex align-items-center gap-2">
            <span class="avatar rounded-circle bg-primary text-white fw-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        </a>
        <a href="{{ route('logout') }}" class="btn btn-danger">
            Logout
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-light">Daftar</a>
    @endif
</div>


    </div>
</header>
