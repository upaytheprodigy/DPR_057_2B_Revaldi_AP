@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Tambah Data Penggajian</h1>
	<form action="{{ route('penggajian.store') }}" method="POST">
		@csrf
		<div class="mb-3">
			<label for="id_anggota" class="form-label">Nama Anggota</label>
			<select name="id_anggota" class="form-control" required>
				<option value="">-- Pilih Anggota --</option>
				@foreach ($anggotas as $anggota)
					<option value="{{ $anggota->id_anggota }}">{{ $anggota->nama_depan }}</option>
				@endforeach
			</select>
		</div>
		<div class="mb-3">
			<label for="id_komponen_gaji" class="form-label">Komponen Gaji</label>
			<select name="id_komponen_gaji" class="form-control" required>
				<option value="">-- Pilih Komponen Gaji --</option>
				@foreach ($komponens as $komponen)
					<option value="{{ $komponen->id_komponen_gaji }}">{{ $komponen->nama_komponen }} (Rp {{ number_format($komponen->nominal, 2, ',', '.') }})</option>
				@endforeach
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
	</form>
</div>
@endsection
