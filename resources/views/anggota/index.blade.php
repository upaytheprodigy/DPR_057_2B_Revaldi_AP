@extends('layouts.app')

@section('title', 'Data Anggota DPR')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Anggota DPR</h2>
            @if(Auth::user()->role == 'Admin')
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Anggota
            </a>
            @endif
        </div>

        <!-- Form Pencarian -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('anggota.index') }}" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari berdasarkan Nama Depan, Nama Belakang, Jabatan, atau ID Anggota" 
                               value="{{ $search }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Anggota -->
        <div class="card">
            <div class="card-body">
                @if($anggota->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Anggota</th>
                                <th>Gelar Depan</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Gelar Belakang</th>
                                <th>Jabatan</th>
                                <th>Status Pernikahan</th>
                                <th>Jumlah Anak</th>
                                @if(Auth::user()->role == 'Admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota as $item)
                            <tr>
                                <td>{{ $item->id_anggota }}</td>
                                <td>{{ $item->gelar_depan }}</td>
                                <td>{{ $item->nama_depan }}</td>
                                <td>{{ $item->nama_belakang }}</td>
                                <td>{{ $item->gelar_belakang }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $item->jabatan }}</span>
                                </td>
                                <td>{{ $item->status_pernikahan }}</td>
                                <td>{{ $item->jumlah_anak }}</td>
                                @if(Auth::user()->role == 'Admin')
                                <td>
                                    <a href="{{ route('anggota.edit', $item->id_anggota) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $item->id_anggota }})">Hapus</button>
                                    
                                    <form id="delete-form-{{ $item->id_anggota }}" 
                                          action="{{ route('anggota.destroy', $item->id_anggota) }}" 
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
                    {{ $anggota->links() }}
                </div>
                @else
                <div class="alert alert-info">
                    Tidak ada data anggota DPR.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('PERHATIAN!\nMenghapus data anggota akan menghapus semua data penggajian yang terkait.\nApakah Anda yakin ingin melanjutkan?')) {
        try {
            document.getElementById('delete-form-' + id).submit();
        } catch (error) {
            alert('Terjadi kesalahan saat menghapus data: ' + error.message);
        }
    }
}
</script>
@endsection