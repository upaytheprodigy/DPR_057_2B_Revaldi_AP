@extends('layouts.app')

@section('title', 'Tambah Komponen Gaji')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Komponen Gaji & Tunjangan</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('komponen-gaji.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_komponen" class="form-label">Nama Komponen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_komponen') is-invalid @enderror" 
                               id="nama_komponen" name="nama_komponen" value="{{ old('nama_komponen') }}" 
                               placeholder="Contoh: Gaji Pokok, Tunjangan Istri/Suami" required>
                        @error('nama_komponen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Gaji Pokok" {{ old('kategori') == 'Gaji Pokok' ? 'selected' : '' }}>Gaji Pokok</option>
                            <option value="Tunjangan Melekat" {{ old('kategori') == 'Tunjangan Melekat' ? 'selected' : '' }}>Tunjangan Melekat</option>
                            <option value="Tunjangan Lain" {{ old('kategori') == 'Tunjangan Lain' ? 'selected' : '' }}>Tunjangan Lain</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jabatan') is-invalid @enderror" 
                                id="jabatan" name="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Ketua" {{ old('jabatan') == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Wakil Ketua" {{ old('jabatan') == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="Anggota" {{ old('jabatan') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                            <option value="Semua" {{ old('jabatan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        </select>
                        <small class="text-muted">Pilih "Semua" jika komponen berlaku untuk semua jabatan</small>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nominal') is-invalid @enderror" 
                               id="nominal" name="nominal" value="{{ old('nominal') }}" 
                               min="0" step="1000" placeholder="Contoh: 5000000" required>
                        @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select class="form-select @error('satuan') is-invalid @enderror" 
                                id="satuan" name="satuan" required>
                            <option value="">-- Pilih Satuan --</option>
                            <option value="Bulan" {{ old('satuan') == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                            <option value="Hari" {{ old('satuan') == 'Hari' ? 'selected' : '' }}>Hari</option>
                            <option value="Periode" {{ old('satuan') == 'Periode' ? 'selected' : '' }}>Periode</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('komponen-gaji.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection