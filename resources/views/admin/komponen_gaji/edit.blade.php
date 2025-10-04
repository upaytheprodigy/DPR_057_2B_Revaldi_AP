@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Komponen Gaji</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('komponen-gaji.update',$komponenGaji->id_komponen_gaji) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Komponen:</strong>
                    <input type="text" name="nama_komponen" value="{{ $komponenGaji->nama_komponen }}" class="form-control" placeholder="Nama Komponen">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kategori:</strong>
                    <select name="kategori" class="form-control">
                        <option value="Gaji Pokok" {{ $komponenGaji->kategori == 'Gaji Pokok' ? 'selected' : '' }}>Gaji Pokok</option>
                        <option value="Tunjangan Melekat" {{ $komponenGaji->kategori == 'Tunjangan Melekat' ? 'selected' : '' }}>Tunjangan Melekat</option>
                        <option value="Tunjangan Lain" {{ $komponenGaji->kategori == 'Tunjangan Lain' ? 'selected' : '' }}>Tunjangan Lain</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Jabatan:</strong>
                    <select name="jabatan" class="form-control">
                        <option value="Ketua" {{ $komponenGaji->jabatan == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ $komponenGaji->jabatan == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Anggota" {{ $komponenGaji->jabatan == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nominal:</strong>
                    <input type="number" name="nominal" value="{{ $komponenGaji->nominal }}" class="form-control" placeholder="Nominal">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Satuan:</strong>
                    <select name="satuan" class="form-control">
                        <option value="Bulan" {{ $komponenGaji->satuan == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                        <option value="Periode" {{ $komponenGaji->satuan == 'Periode' ? 'selected' : '' }}>Periode</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
