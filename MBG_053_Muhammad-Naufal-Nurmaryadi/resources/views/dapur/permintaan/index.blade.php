@extends('layouts.app')
@section('title', 'Daftar Permintaan Saya')

@section('content')
    <h1>Daftar Permintaan Saya</h1>

    @foreach($permintaans as $permintaan)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>
                    Permintaan untuk: <strong>{{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</strong>
                </span>
                <span class="badge 
                    @if($permintaan->status == 'menunggu') bg-secondary
                    @elseif($permintaan->status == 'disetujui') bg-success
                    @else bg-danger
                    @endif">
                    {{ ucfirst($permintaan->status) }}
                </span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $permintaan->menu_makan }} ({{ $permintaan->jumlah_porsi }} Porsi)</h5>
                <h6>Bahan yang diminta:</h6>
                <ul>
                    @foreach($permintaan->details as $detail)
                        @if($detail->bahanBaku)
                            <li>
                                {{ $detail->bahanBaku->nama }} - {{ $detail->jumlah_diminta }} {{ $detail->bahanBaku->satuan }}
                            </li>
                        @else
                            <li class="text-danger fst-italic">
                                -- Data bahan baku untuk item ini telah dihapus --
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
@endsection