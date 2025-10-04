@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Komponen Gaji</h1>
    <a href="{{ route('komponen-gaji.create') }}" class="btn btn-primary mb-3">Tambah Komponen Gaji</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Komponen</th>
            <th>Kategori</th>
            <th>Jabatan</th>
            <th>Nominal</th>
            <th>Satuan</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($komponengajis as $komponengaji)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $komponengaji->nama_komponen }}</td>
            <td>{{ $komponengaji->kategori }}</td>
            <td>{{ $komponengaji->jabatan }}</td>
            <td>{{ $komponengaji->nominal }}</td>
            <td>{{ $komponengaji->satuan }}</td>
            <td>
                <form action="{{ route('komponen-gaji.destroy',$komponengaji->id_komponen_gaji) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('komponen-gaji.edit',$komponengaji->id_komponen_gaji) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
