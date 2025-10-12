<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', 'Example')
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    {{-- Navbar sudah disematkan di sini dan menangani tombol Login/Logout --}}
    @include('components.navbar')

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">

                        {{-- 1. DASHBOARD (Terlihat oleh SEMUA ORANG) --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>

                        {{-- FIX UTAMA: DAFTAR POST (Hanya terlihat jika BUKAN Admin atau JIKA belum Login) --}}
                        {{-- Logika: Tampilkan jika TIDAK Auth, ATAU jika Auth tapi role BUKAN 1 (Bukan Admin) --}}
                        @if (!Auth::check() || (Auth::check() && Auth::user()->role != 1))
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('posts.public.index') || Route::is('posts.public.show') ? 'active' : '' }}" href="{{ route('posts.public.index') }}">
                                    <i class="fas fa-list-alt me-2"></i> Daftar Post
                                </a>
                            </li>
                        @endif

                        {{-- ============================================================= --}}
                        {{-- START: MENU HANYA JIKA SUDAH LOGIN (Auth) --}}
                        {{-- ============================================================= --}}

                        @auth

                            {{-- 3. PROFIL SAYA (Terlihat oleh User & Admin) --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle me-2"></i> Profil Saya
                                </a>
                            </li>

                            {{-- 4. MENU ADMIN (Hanya Role 1) --}}
                            @if (Auth::user()->role == 1)

                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                                        <i class="fas fa-pen me-2"></i> Data Post 
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="fas fa-users me-2"></i> Data User
                                    </a>
                                </a>
                                </li>

                            @endif

                        @endauth

                        {{-- ============================================================= --}}
                        {{-- END: MENU AUTHENTICATED --}}
                        {{-- ============================================================= --}}

                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('header-title', 'Example')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>

</html>