<header class="navbar navbar-dark bg-dark fixed-top shadow-sm px-3 py-2">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        {{-- Logo / Nama Brand --}}
        <a class="navbar-brand fw-bold fs-5" href="{{ route('home') }}">
            <i class="bi bi-building me-2"></i>Company Name
        </a>

        {{-- Tombol Sidebar untuk Mobile --}}
        <button class="navbar-toggler d-md-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Bagian Kanan (Login / Logout) --}}
        <div class="d-flex align-items-center">

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            @endguest

            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm px-3 d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                    </button>
                </form>
            @endauth

        </div>
    </div>
</header>
