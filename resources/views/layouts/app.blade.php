<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Aplikasi Gaji DPR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Aplikasi Gaji DPR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}" 
                           href="{{ route('anggota.index') }}">Data Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('penggajian.*') ? 'active' : '' }}" 
                           href="{{ route('penggajian.index') }}">Data Penggajian</a>
                    </li>
                    @if(Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('komponen-gaji.*') ? 'active' : '' }}" 
                        href="{{ route('komponen-gaji.index') }}">Komponen Gaji</a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->username }} ({{ ucfirst(Auth::user()->role) }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="mt-5 py-3 bg-light">
        <div class="container text-center text-muted">
            <small>&copy; {{ date('Y') }} Aplikasi Gaji DPR - Transparansi Penggajian</small>
        </div>
    </footer>
</body>
</html>