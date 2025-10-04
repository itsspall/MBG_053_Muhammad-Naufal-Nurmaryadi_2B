<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi MBG')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { 
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
            border-bottom: 1px solid #dee2e6;
        }
        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            border: none;
            min-width: 15rem;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .dropdown-item i {
            width: 1.25rem; /* Ensure icons align nicely */
            text-align: center;
        }
        .dropdown-item.active, .dropdown-item:active {
            background-color: #e9ecef;
            color: #000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid px-4">
            {{-- Brand Logo di Kiri --}}
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-box-seam-fill me-2 text-primary"></i>
                <span>MBG Stock</span>
            </a>
            
            {{-- Dropdown Pengguna di Kanan --}}
            @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            {{-- User Info Header --}}
                            <li>
                                <div class="px-3 py-2">
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
                            {{-- Menu Navigasi Sesuai Role --}}
                            @if(auth()->user()->role === 'gudang')
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('gudang.bahan-baku.*') ? 'active' : '' }}" href="{{ route('gudang.bahan-baku.index') }}">
                                        <i class="bi bi-boxes"></i> <span>Bahan Baku</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('gudang.permintaan.*') ? 'active' : '' }}" href="{{ route('gudang.permintaan.index') }}">
                                        <i class="bi bi-inbox-fill"></i> <span>Permintaan Masuk</span>
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'dapur')
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('dapur.permintaan.index') ? 'active' : '' }}" href="{{ route('dapur.permintaan.index') }}">
                                        <i class="bi bi-journal-text"></i> <span>Permintaan Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('dapur.permintaan.create') ? 'active' : '' }}" href="{{ route('dapur.permintaan.create') }}">
                                        <i class="bi bi-plus-circle"></i> <span>Buat Permintaan Baru</span>
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>

                            {{-- Tombol Logout --}}
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    {{-- JAVASCRIPT SECTION --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('partials.sweetalert')

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