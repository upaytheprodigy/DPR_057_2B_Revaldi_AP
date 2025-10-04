@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard</h2>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->username }}</strong>!</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Anggota DPR</h5>
                <h2 class="card-text">{{ $totalAnggota }}</h2>
                <small>Semua Jabatan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Ketua</h5>
                <h2 class="card-text">{{ $totalKetua }}</h2>
                <small>Jabatan Ketua</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Wakil Ketua</h5>
                <h2 class="card-text">{{ $totalWakilKetua }}</h2>
                <small>Jabatan Wakil Ketua</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Anggota</h5>
                <h2 class="card-text">{{ $totalAnggotaBiasa }}</h2>
                <small>Jabatan Anggota</small>
            </div>
        </div>
    </div>
</div>

<!-- Info Role -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Akun</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="150"><strong>Username</strong></td>
                        <td>: {{ Auth::user()->username }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td>: <span class="badge bg-{{ Auth::user()->role == 'Admin' ? 'danger' : 'info' }}">
                            {{ ucfirst(Auth::user()->role) }}
                        </span></td>
                    </tr>
                   <tr>
                        <td><strong>Hak Akses</strong></td>
                        <td>: 
                            @if(Auth::user()->role == 'Admin')
                                <span class="text-success">Full Access (CRUD)</span>
                            @else
                                <span class="text-warning">Read Only</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Menu yang Tersedia</h5>
            </div>
            <div class="card-body">
                @if(Auth::user()->role == 'Admin')
                    <div class="alert alert-info mb-2">
                        <strong>Menu Admin:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Kelola Data Anggota DPR</li>
                            <li>Kelola Komponen Gaji & Tunjangan</li>
                            <li>Kelola Data Penggajian</li>
                            <li>Lihat Semua Data</li>
                        </ul>
                    </div>
                @else
                    <div class="alert alert-warning mb-2">
                        <strong>Menu Public:</strong>
                        <ul class="mb-0 mt-2">
                            <li>👁️ Lihat Data Anggota DPR (Read Only)</li>
                            <li>👁️ Lihat Data Penggajian (Read Only)</li>
                        </ul>
                    </div>
                @endif
                
                <a href="{{ route('anggota.index') }}" class="btn btn-primary btn-sm w-100 mt-2">
                    Lihat Data Anggota DPR
                </a>
                @if(Auth::user()->role == 'Admin')
                <a href="{{ route('komponen-gaji.index') }}" class="btn btn-secondary btn-sm w-100 mt-2">
                    Lihat Data Komponen Gaji
                </a>
                    <a href="{{ route('penggajian.index') }}" class="btn btn-info btn-sm w-100 mt-2">
                        Lihat Data Penggajian
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions (Admin Only) -->
@if(Auth::user()->role == 'Admin')
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('anggota.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Anggota DPR
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('komponen-gaji.create') }}" class="btn btn-warning w-100">
                            <i class="bi bi-cash-stack"></i> Tambah Komponen Gaji
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('penggajian.create') }}" class="btn btn-info w-100">
                            <i class="bi bi-file-earmark-text"></i> Tambah Data Penggajian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Info Aplikasi -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <h5>Aplikasi Penghitungan & Transparansi Gaji DPR</h5>
                <p class="text-muted mb-0">
                    Sistem informasi untuk menghitung dan menampilkan penghasilan anggota DPR RI 
                    berdasarkan jabatan dan kondisi keluarga secara transparan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection