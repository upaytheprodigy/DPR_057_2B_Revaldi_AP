@extends('layouts.app')

@section('title', 'Komponen Gaji & Tunjangan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Komponen Gaji & Tunjangan</h2>
            @if(Auth::user()->role == 'Admin')
            <a href="{{ route('komponen-gaji.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Komponen
            </a>
            @endif
        </div>

        <!-- Form Pencarian -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('komponen-gaji.index') }}" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari berdasarkan Nama Komponen, Kategori, Jabatan, Nominal, Satuan, atau ID Komponen" 
                               value="{{ $search }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Komponen Gaji -->
        <div class="card">
            <div class="card-body">
                @if($komponenGaji->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Komponen</th>
                                <th>Nama Komponen</th>
                                <th>Kategori</th>
                                <th>Jabatan</th>
                                <th>Nominal</th>
                                <th>Satuan</th>
                                @if(Auth::user()->role == 'Admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($komponenGaji as $item)
                            <tr>
                                <td>{{ $item->id_komponen_gaji }}</td>
                                <td>{{ $item->nama_komponen }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->jabatan == 'Semua' ? 'secondary' : 'primary' }}">
                                        {{ $item->jabatan }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>{{ $item->satuan }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td>
                                    <a href="{{ route('komponen-gaji.edit', $item->id_komponen_gaji) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $item->id_komponen_gaji }})">Hapus</button>
                                    
                                    <form id="delete-form-{{ $item->id_komponen_gaji }}" 
                                          action="{{ route('komponen-gaji.destroy', $item->id_komponen_gaji) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-3">
                    {{ $komponenGaji->links() }}
                </div>
                @else
                <div class="alert alert-info">
                    Tidak ada data komponen gaji.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus komponen gaji ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection