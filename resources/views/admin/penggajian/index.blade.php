@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data Penggajian</h1>
    <a href="{{ route('penggajian.create') }}" class="btn btn-primary mb-3">Tambah Data Penggajian</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Komponen Gaji</th>
            <th>Nominal</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($penggajians as $penggajian)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $penggajian->anggota->nama_depan }}</td>
            <td>{{ $penggajian->komponenGaji->nama_komponen }}</td>
            <td>Rp {{ number_format($penggajian->komponenGaji->nominal, 2, ',', '.') }}</td>
            <td>
                <form action="{{ route('penggajian.destroy', [$penggajian->id_komponen_gaji, $penggajian->id_anggota]) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('penggajian.edit', [$penggajian->id_komponen_gaji, $penggajian->id_anggota]) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
