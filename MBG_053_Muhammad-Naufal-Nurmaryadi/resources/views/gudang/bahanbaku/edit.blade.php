@extends('layouts.app')
@section('title', 'Edit Bahan Baku')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('gudang.bahan-baku.update', $bahanBaku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                {{-- Card Header dengan Judul dan Ikon --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Bahan Baku: <strong>{{ $bahanBaku->nama }}</strong>
                    </h5>
                    <a href="{{ route('gudang.bahan-baku.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    {{-- Informasi Dasar --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Bahan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $bahanBaku->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="form-label">Kategori</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bookmark-fill"></i></span>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $bahanBaku->kategori) }}">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Informasi Stok --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="jumlah" class="form-label">Jumlah Stok & Satuan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box-fill"></i></span>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $bahanBaku->jumlah) }}" placeholder="Jumlah" required>
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $bahanBaku->satuan) }}" placeholder="Satuan (kg, liter, butir)" required>
                                @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-text">Masukkan jumlah stok dan satuannya (contoh: 100 kg).</div>
                        </div>
                    </div>

                    {{-- Informasi Tanggal --}}
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-plus-fill"></i></span>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $bahanBaku->tanggal_masuk) }}" required>
                                @error('tanggal_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-x-fill"></i></span>
                                <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $bahanBaku->tanggal_kadaluarsa) }}" required>
                                @error('tanggal_kadaluarsa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Footer untuk Tombol Aksi --}}
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill me-2"></i>Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection