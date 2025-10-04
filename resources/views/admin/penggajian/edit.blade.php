@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Edit Data Penggajian</h1>
	<form action="{{ route('penggajian.update', [$penggajian->id_komponen_gaji, $penggajian->id_anggota]) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="mb-3">
			<label for="id_anggota" class="form-label">Nama Anggota</label>
			<input type="text" class="form-control" value="{{ $anggotas->where('id_anggota', $penggajian->id_anggota)->first()->nama_depan ?? '' }}" readonly>
			<input type="hidden" name="id_anggota" value="{{ $penggajian->id_anggota }}">
		</div>
		<div class="mb-3">
			<label for="id_komponen_gaji" class="form-label">Komponen Gaji</label>
			<select name="id_komponen_gaji" class="form-control" required>
				<option value="">-- Pilih Komponen Gaji --</option>
				@foreach ($komponens as $komponen)
					<option value="{{ $komponen->id_komponen_gaji }}" {{ $penggajian->id_komponen_gaji == $komponen->id_komponen_gaji ? 'selected' : '' }}>{{ $komponen->nama_komponen }} (Rp {{ number_format($komponen->nominal, 2, ',', '.') }})</option>
				@endforeach
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Update</button>
		<a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
	</form>
</div>
@endsection
