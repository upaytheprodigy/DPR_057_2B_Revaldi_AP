@extends('layouts.app')

@section('title', 'Detail Penggajian')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Data Penggajian</h4>
                <a href="{{ route('penggajian.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informasi Anggota</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="180"><strong>ID Anggota</strong></td>
                                        <td>: {{ $anggota->id_anggota }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap</strong></td>
                                        <td>: {{ trim("$anggota->gelar_depan $anggota->nama_depan $anggota->nama_belakang $anggota->gelar_belakang") }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jabatan</strong></td>
                                        <td>: <span class="badge bg-primary">{{ $anggota->jabatan }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="180"><strong>Status Pernikahan</strong></td>
                                        <td>: {{ $anggota->status_pernikahan }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah Anak</strong></td>
                                        <td>: {{ $anggota->jumlah_anak }} orang</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Anak Dihitung</strong></td>
                                        <td>: <span class="badge bg-info">{{ min($anggota->jumlah_anak, 2) }} orang</span> <small class="text-muted">(Maksimal 2 anak)</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Komponen Gaji & Tunjangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Komponen</th>
                                        <th>Kategori</th>
                                        <th>Jabatan</th>
                                        <th>Nominal</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $totalBulanan = 0;
                                        $totalTahunan = 0;
                                    @endphp
                                    @foreach($anggota->penggajian as $item)
                                        {{-- ======================================================= --}}
                                        {{-- ## PERBAIKAN UTAMA: Cek apakah relasi komponen ada ## --}}
                                        {{-- ======================================================= --}}
                                        @if ($item->komponen)
                                            @php
                                                $komponen = $item->komponen;
                                                $isDihitung = true;
                                                $keterangan = '';
                                                $nominalDihitung = $komponen->nominal;
                                                
                                                // Validasi Tunjangan Istri/Suami
                                                if ($komponen->nama_komponen == 'Tunjangan Istri/Suami' && $anggota->status_pernikahan != 'Kawin') {
                                                    $isDihitung = false;
                                                    $keterangan = 'Tidak dihitung (Belum Kawin)';
                                                }
                                                
                                                // Validasi Tunjangan Anak
                                                if ($komponen->nama_komponen == 'Tunjangan Anak') {
                                                    if ($anggota->jumlah_anak == 0) {
                                                        $isDihitung = false;
                                                        $keterangan = 'Tidak dihitung (Tidak punya anak)';
                                                    } else {
                                                        $jumlahAnakDihitung = min($anggota->jumlah_anak, 2);
                                                        $nominalDihitung = $komponen->nominal * $jumlahAnakDihitung;
                                                        $keterangan = "Dihitung untuk {$jumlahAnakDihitung} anak";
                                                    }
                                                }
                                                
                                                // Hitung total jika valid
                                                if ($isDihitung) {
                                                    if ($komponen->satuan == 'Bulan') {
                                                        $totalBulanan += $nominalDihitung;
                                                    } else { // Asumsi satuan lain adalah Tahunan/Periode
                                                        $totalTahunan += $nominalDihitung;
                                                    }
                                                }
                                            @endphp
                                            <tr class="{{ !$isDihitung ? 'table-secondary text-muted' : '' }}">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $komponen->nama_komponen }}</td>
                                                <td>{{ $komponen->kategori }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $komponen->jabatan == 'Semua' ? 'secondary' : 'primary' }}">
                                                        {{ $komponen->jabatan }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    @if($komponen->nama_komponen == 'Tunjangan Anak' && $isDihitung && $anggota->jumlah_anak > 0)
                                                        <small class="text-muted">Rp {{ number_format($komponen->nominal, 0, ',', '.') }} x {{ min($anggota->jumlah_anak, 2) }} =</small><br>
                                                        <strong>Rp {{ number_format($nominalDihitung, 0, ',', '.') }}</strong>
                                                    @else
                                                        Rp {{ number_format($nominalDihitung, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td>{{ $komponen->satuan }}</td>
                                                <td>
                                                    @if($keterangan)
                                                        <small class="text-{{ $isDihitung ? 'info' : 'danger' }}">{{ $keterangan }}</small>
                                                    @else
                                                        <small class="text-success">Dihitung</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Take Home Pay</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Total Komponen Bulanan</h6>
                                        <h3 class="text-primary mb-0">Rp {{ number_format($totalBulanan, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Per Bulan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Total Komponen Lainnya</h6>
                                        <h3 class="text-info mb-0">Rp {{ number_format($totalTahunan, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Per Tahun/Periode</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Take Home Pay (Bulanan)</h6>
                                        <h2 class="text-success fw-bold mb-0">Rp {{ number_format($totalBulanan, 0, ',', '.') }}</h2>
                                        <small class="text-muted">Penghasilan per Bulan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">Take Home Pay (Tahunan)</h6>
                                        <h2 class="text-success fw-bold mb-0">Rp {{ number_format(($totalBulanan * 12) + $totalTahunan, 0, ',', '.') }}</h2>
                                        <small class="text-muted">Penghasilan per Tahun</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small>
                                <i class="bi bi-info-circle"></i> <strong>Catatan:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Take Home Pay Bulanan = Total semua komponen dengan satuan "Bulan".</li>
                                    <li>Take Home Pay Tahunan = (Total Bulanan × 12) + Total komponen dengan satuan lainnya.</li>
                                    <li>Tunjangan Anak dihitung maksimal untuk 2 anak.</li>
                                    <li>Tunjangan Istri/Suami hanya dihitung jika status pernikahan "Kawin".</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>

                @if(strtolower(Auth::user()->role) == 'admin')
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <div>
                        <a href="{{ route('penggajian.edit', $anggota->id_anggota) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Komponen
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="bi bi-trash"></i> Hapus Penggajian
                        </button>
                        <form id="delete-form" action="{{ route('penggajian.destroy', $anggota->id_anggota) }}" 
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus semua data penggajian anggota ini? Data anggota TIDAK akan terhapus.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection