<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi MBG')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); }
        .navbar-nav .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Pemantauan Bahan Baku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
                @auth
                    <ul class="navbar-nav mx-auto">
                        @if(auth()->user()->role === 'gudang')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('gudang.bahan-baku.*') ? 'active' : '' }}" href="{{ route('gudang.bahan-baku.index') }}">Bahan Baku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('gudang.permintaan.*') ? 'active' : '' }}" href="{{ route('gudang.permintaan.index') }}">Permintaan Masuk</a>
                            </li>
                        @elseif(auth()->user()->role === 'dapur')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dapur.permintaan.*') ? 'active' : '' }}" href="{{ route('dapur.permintaan.index') }}">Permintaan Saya</a>
                            </li>
                        @endif
                    </ul>
                @endauth

                <ul class="navbar-nav ms-auto"> {{-- Menggunakan ms-auto agar ke kanan --}}
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    {{-- JAVASCRIPT SECTION --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- 1. Load library SweetAlert terlebih dahulu --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- 2. Baru panggil script notifikasi yang menggunakan library tersebut --}}
    @include('partials.sweetalert')

    {{-- Script untuk konfirmasi hapus (tidak perlu di-push dari layout) --}}
    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-button')) {
                e.preventDefault();
                const form = e.target.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>