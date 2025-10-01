@extends('layout.app')
@section('title', 'Daftar Bahan Baku')

@section('content')
    <h1>Daftar Bahan Baku</h1>
    <a href="{{ route('gudang.bahan-baku.create') }}" class="btn btn-primary mb-3">Tambah Bahan Baku</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tgl Kadaluarsa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bahanBakus as $bahan)
            <tr>
                <td>{{ $bahan->nama }}</td>
                <td>{{ $bahan->kategori }}</td>
                <td>{{ $bahan->jumlah }} {{ $bahan->satuan }}</td>
                <td>
                    <span class="badge 
                        @if($bahan->status == 'tersedia') bg-success 
                        @elseif($bahan->status == 'segera_kadaluarsa') bg-warning
                        @elseif($bahan->status == 'kadaluarsa' || $bahan->status == 'habis') bg-danger
                        @endif">
                        {{ str_replace('_', ' ', $bahan->status) }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($bahan->tanggal_kadaluarsa)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('gudang.bahan-baku.edit', $bahan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('gudang.bahan-baku.destroy', $bahan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection