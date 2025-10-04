@extends('layouts.app')

@section('title', 'Edit Anggota DPR')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Anggota DPR</h4>
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

                <form method="POST" action="{{ route('anggota.update', $anggota->id_anggota) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="gelar_depan" class="form-label">Gelar Depan</label>
                        <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" 
                               value="{{ old('gelar_depan', $anggota->gelar_depan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama_depan" class="form-label">Nama Depan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_depan') is-invalid @enderror" 
                               id="nama_depan" name="nama_depan" 
                               value="{{ old('nama_depan', $anggota->nama_depan) }}" required>
                        @error('nama_depan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_belakang" class="form-label">Nama Belakang</label>
                        <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" 
                               value="{{ old('nama_belakang', $anggota->nama_belakang) }}">
                    </div>

                    <div class="mb-3">
                        <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                        <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" 
                               value="{{ old('gelar_belakang', $anggota->gelar_belakang) }}">
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jabatan') is-invalid @enderror" 
                                id="jabatan" name="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Ketua" {{ old('jabatan', $anggota->jabatan) == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Wakil Ketua" {{ old('jabatan', $anggota->jabatan) == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="Anggota" {{ old('jabatan', $anggota->jabatan) == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_pernikahan" class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pernikahan') is-invalid @enderror" 
                                id="status_pernikahan" name="status_pernikahan" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Kawin" {{ old('status_pernikahan', $anggota->status_pernikahan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Belum Kawin" {{ old('status_pernikahan', $anggota->status_pernikahan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        </select>
                        @error('status_pernikahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_anak" class="form-label">Jumlah Anak <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah_anak') is-invalid @enderror" 
                               id="jumlah_anak" name="jumlah_anak" 
                               value="{{ old('jumlah_anak', $anggota->jumlah_anak) }}" 
                               min="0" required>
                        @error('jumlah_anak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection