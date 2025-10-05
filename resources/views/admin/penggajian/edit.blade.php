@extends('layouts.app')

@section('title', 'Edit Penggajian')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Penggajian</h4>
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

                <!-- Info Anggota -->
                <div class="alert alert-info mb-4">
                    <h6 class="fw-bold">Informasi Anggota:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>ID Anggota:</strong> {{ $anggota->id_anggota }}</p>
                            <p class="mb-1"><strong>Nama:</strong> {{ $anggota->gelar_depan }} {{ $anggota->nama_depan }} {{ $anggota->nama_belakang }} {{ $anggota->gelar_belakang }}</p>
                            <p class="mb-1"><strong>Jabatan:</strong> <span class="badge bg-primary">{{ $anggota->jabatan }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status Pernikahan:</strong> {{ $anggota->status_pernikahan }}</p>
                            <p class="mb-1"><strong>Jumlah Anak:</strong> {{ $anggota->jumlah_anak }} orang</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('penggajian.update', $anggota->id_anggota) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Pilih Komponen Gaji -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Komponen Gaji <span class="text-danger">*</span></label>
                        <div class="alert alert-warning">
                            <small><i class="bi bi-info-circle"></i> Pilih komponen gaji yang ingin diterapkan untuk anggota ini</small>
                        </div>
                        <div class="row">
                            @foreach($komponenGaji as $komponen)
                            <div class="col-md-6 mb-2">
                                <div class="form-check card p-3 {{ in_array($komponen->id_komponen_gaji, $komponenTerpilih) ? 'bg-light border-primary' : '' }}">
                                    <input class="form-check-input" type="checkbox" 
                                           name="id_komponen[]" value="{{ $komponen->id_komponen_gaji }}" 
                                           id="komponen{{ $komponen->id_komponen_gaji }}"
                                           {{ in_array($komponen->id_komponen_gaji, $komponenTerpilih) ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="komponen{{ $komponen->id_komponen_gaji }}">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $komponen->nama_komponen }}</strong>
                                                <br><small class="text-muted">{{ $komponen->kategori }} - {{ $komponen->jabatan }}</small>
                                            </div>
                                            <div class="text-end">
                                                <strong class="text-success">Rp {{ number_format($komponen->nominal, 0, ',', '.') }}</strong>
                                                <br><small class="text-muted">per {{ $komponen->satuan }}</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('id_komponen_gaji')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection