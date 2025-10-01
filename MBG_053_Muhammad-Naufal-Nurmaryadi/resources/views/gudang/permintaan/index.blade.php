@extends('layout.app')

@section('title', 'Daftar Permintaan Masuk')

@section('content')
    <h1>Daftar Permintaan Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="accordion" id="accordionPermintaan">
        @forelse($permintaans as $permintaan)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $permintaan->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $permintaan->id }}">
                        <div class="d-flex justify-content-between w-100 me-3">
                            <span>
                                Pemohon: <strong>{{ $permintaan->pemohon->name }}</strong> | Menu: {{ $permintaan->menu_makan }}
                            </span>
                            <span class="badge 
                                @if($permintaan->status == 'menunggu') bg-secondary
                                @elseif($permintaan->status == 'disetujui') bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst($permintaan->status) }}
                            </span>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $permintaan->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionPermintaan">
                    <div class="card-body">
                        <p><strong>Tanggal Masak:</strong> {{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</p>
                        <p><strong>Jumlah Porsi:</strong> {{ $permintaan->jumlah_porsi }} Porsi</p>
                        <h6>Bahan yang diminta:</h6>
                        <ul>
                            @foreach($permintaan->details as $detail)
                                <li>{{ $detail->bahanBaku->nama }} - <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahanBaku->satuan }}</strong> (Stok: {{ $detail->bahanBaku->jumlah }})</li>
                            @endforeach
                        </ul>

                        @if ($permintaan->status == 'menunggu')
                            <hr>
                            <form action="{{ route('gudang.permintaan.proses', $permintaan->id) }}" method="POST">
                                @csrf
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="status" value="disetujui" class="btn btn-success me-2">Setujui</button>
                                    <button type="submit" name="status" value="ditolak" class="btn btn-danger">Tolak</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Tidak ada permintaan yang masuk.
            </div>
        @endforelse
    </div>
@endsection