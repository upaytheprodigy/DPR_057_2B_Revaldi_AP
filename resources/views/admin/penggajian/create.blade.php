@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Penggajian</h4>
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

                <form method="POST" action="{{ route('penggajian.store') }}" id="formPenggajian">
                    @csrf
                    
                    <!-- Pilih Anggota -->
                    <div class="mb-4">
                        <label for="id_anggota" class="form-label fw-bold">1. Pilih Anggota DPR <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_anggota') is-invalid @enderror" 
                                id="id_anggota" name="id_anggota" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $item)
                            <option value="{{ $item->id_anggota }}" {{ old('id_anggota') == $item->id_anggota ? 'selected' : '' }}>
                                {{ $item->id_anggota }} - {{ $item->gelar_depan }} {{ $item->nama_depan }} {{ $item->nama_belakang }} {{ $item->gelar_belakang }} ({{ $item->jabatan }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Info Anggota -->
                    <div id="infoAnggota" class="alert alert-info" style="display: none;">
                        <h6 class="fw-bold">Informasi Anggota:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama:</strong> <span id="namaAnggota">-</span></p>
                                <p class="mb-1"><strong>Jabatan:</strong> <span id="jabatanAnggota">-</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status Pernikahan:</strong> <span id="statusNikah">-</span></p>
                                <p class="mb-1"><strong>Jumlah Anak:</strong> <span id="jumlahAnak">-</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Komponen Gaji -->
                    <div class="mb-4" id="komponenSection" style="display: none;">
                        <label class="form-label fw-bold">2. Pilih Komponen Gaji <span class="text-danger">*</span></label>
                        <div class="alert alert-warning">
                            <small><i class="bi bi-info-circle"></i> Komponen yang ditampilkan sesuai dengan jabatan anggota yang dipilih</small>
                        </div>
                        <div id="komponenGajiList" class="row">
                            <!-- Komponen akan dimuat via JavaScript -->
                        </div>
                        @error('id_komponen')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('id_anggota').addEventListener('change', function() {
    const idAnggota = this.value;
    
    if (idAnggota) {
        // Fetch data anggota dan komponen gaji
        fetch(`/penggajian/get-komponen/${idAnggota}`)
            .then(response => response.json())
            .then(data => {
                // Tampilkan info anggota
                document.getElementById('infoAnggota').style.display = 'block';
                document.getElementById('namaAnggota').textContent = 
                    `${data.anggota.gelar_depan || ''} ${data.anggota.nama_depan} ${data.anggota.nama_belakang || ''} ${data.anggota.gelar_belakang || ''}`.trim();
                document.getElementById('jabatanAnggota').textContent = data.anggota.jabatan;
                document.getElementById('statusNikah').textContent = data.anggota.status_pernikahan;
                document.getElementById('jumlahAnak').textContent = data.anggota.jumlah_anak;
                
                // Tampilkan komponen gaji
                document.getElementById('komponenSection').style.display = 'block';
                const komponenList = document.getElementById('komponenGajiList');
                komponenList.innerHTML = '';
                
                if (data.komponenGaji.length > 0) {
                    data.komponenGaji.forEach(komponen => {
                        const isSelected = data.komponenTerpilih.includes(komponen.id_komponen);
                        const col = document.createElement('div');
                        col.className = 'col-md-6 mb-2';
                        col.innerHTML = `
                            <div class="form-check card p-3 ${isSelected ? 'bg-light' : ''}">
                                <input class="form-check-input" type="checkbox" 
                                       name="id_komponen[]" value="${komponen.id_komponen}" 
                                       id="komponen${komponen.id_komponen}"
                                       ${isSelected ? 'disabled checked' : ''}>
                                <label class="form-check-label w-100" for="komponen${komponen.id_komponen}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>${komponen.nama_komponen}</strong>
                                            <br><small class="text-muted">${komponen.kategori} - ${komponen.jabatan}</small>
                                            ${isSelected ? '<br><small class="text-danger">Sudah ditambahkan</small>' : ''}
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-success">Rp ${parseInt(komponen.nominal).toLocaleString('id-ID')}</strong>
                                            <br><small class="text-muted">per ${komponen.satuan}</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        `;
                        komponenList.appendChild(col);
                    });
                    
                    // Enable submit button
                    document.getElementById('btnSubmit').disabled = false;
                } else {
                    komponenList.innerHTML = '<div class="col-12"><div class="alert alert-warning">Tidak ada komponen gaji yang tersedia untuk jabatan ini.</div></div>';
                    document.getElementById('btnSubmit').disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data komponen gaji.');
            });
    } else {
        document.getElementById('infoAnggota').style.display = 'none';
        document.getElementById('komponenSection').style.display = 'none';
        document.getElementById('btnSubmit').disabled = true;
    }
});
</script>
@endsection