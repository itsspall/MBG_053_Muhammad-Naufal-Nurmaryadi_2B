@extends('layouts.app')
@section('title', 'Daftar Bahan Baku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manajemen Bahan Baku</h1>
        <a href="{{ route('gudang.bahan-baku.create') }}" class="btn btn-primary">
            + Tambah Bahan
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {{-- Search and Filter Form --}}
            <form action="{{ route('gudang.bahan-baku.index') }}" method="GET">
                <div class="row g-2 mb-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama bahan baku..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="segera_kadaluarsa" {{ request('status') == 'segera_kadaluarsa' ? 'selected' : '' }}>Segera Kadaluarsa</option>
                            <option value="kadaluarsa" {{ request('status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                            <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-dark w-100">Filter</button>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Bahan</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Tgl Kadaluarsa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bahanBakus as $bahan)
                        <tr>
                            <td><strong>{{ $bahan->nama }}</strong></td>
                            <td>{{ $bahan->kategori ?? '-' }}</td>
                            <td>{{ $bahan->jumlah }} {{ $bahan->satuan }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    $statusIcon = '';
                                    switch ($bahan->status) {
                                        case 'tersedia':
                                            $statusClass = 'text-bg-success';
                                            $statusIcon = 'bi-check-circle-fill';
                                            break;
                                        case 'segera_kadaluarsa':
                                            $statusClass = 'text-bg-warning';
                                            $statusIcon = 'bi-exclamation-triangle-fill';
                                            break;
                                        case 'kadaluarsa':
                                        case 'habis':
                                            $statusClass = 'text-bg-danger';
                                            $statusIcon = 'bi-x-octagon-fill';
                                            break;
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }} d-flex align-items-center">
                                    <i class="bi {{ $statusIcon }} me-1"></i>
                                    {{ str_replace('_', ' ', $bahan->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($bahan->tanggal_kadaluarsa)->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('gudang.bahan-baku.edit', $bahan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('gudang.bahan-baku.destroy', $bahan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-button">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="p-4">
                                    <p class="mb-0">Data bahan baku tidak ditemukan.</p>
                                    <small>Coba ubah kata kunci pencarian atau filter status Anda.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
{{-- Adding Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.75em;
    }
</style>
@endpush