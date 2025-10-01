@extends('layouts.app')
@section('title', 'Buat Permintaan Bahan Baku')

@section('content')
    <h1>Buat Permintaan Bahan Baku Baru</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dapur.permintaan.store') }}" method="POST">
                @csrf
                {{-- Bagian Atas Form --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="tgl_masak" class="form-label">Tanggal Masak</label>
                        <input type="date" class="form-control @error('tgl_masak') is-invalid @enderror" id="tgl_masak" name="tgl_masak" value="{{ old('tgl_masak') }}" required>
                        @error('tgl_masak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="menu_makan" class="form-label">Menu yang Akan Dibuat</label>
                        <input type="text" class="form-control @error('menu_makan') is-invalid @enderror" id="menu_makan" name="menu_makan" value="{{ old('menu_makan') }}" required>
                        @error('menu_makan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jumlah_porsi" class="form-label">Jumlah Porsi</label>
                        <input type="number" class="form-control @error('jumlah_porsi') is-invalid @enderror" id="jumlah_porsi" name="jumlah_porsi" value="{{ old('jumlah_porsi') }}" required>
                        @error('jumlah_porsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr>

                {{-- Bagian Daftar Bahan Baku Dinamis --}}
                <h5 class="mt-4">Daftar Bahan Baku yang Dibutuhkan</h5>
                @error('bahan') <div class="alert alert-danger">{{ $message }}</div> @enderror
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Nama Bahan</th>
                            <th>Jumlah</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bahan-list">
                        {{-- Baris baru akan ditambahkan di sini oleh JavaScript --}}
                    </tbody>
                </table>
                <button type="button" id="add-bahan" class="btn btn-success btn-sm">Tambah Bahan</button>

                {{-- Tombol Submit --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('dapur.permintaan.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Ajukan Permintaan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
