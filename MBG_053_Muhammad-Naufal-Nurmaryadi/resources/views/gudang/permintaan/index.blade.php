@extends('layouts.app')

@section('title', 'Daftar Permintaan Masuk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Daftar Permintaan Masuk</h1>
    </div>

    {{-- Navigasi Filter --}}
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-status-filter="semua">Semua</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-status-filter="menunggu">Menunggu</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-status-filter="disetujui">Disetujui</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-status-filter="ditolak">Ditolak</button>
        </li>
    </ul>

    @forelse($permintaans as $permintaan)
        <div class="card mb-3 status-card" data-status="{{ $permintaan->status }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Menu: <strong>{{ $permintaan->menu_makan }}</strong>
                </h5>
                <span class="badge fs-6
                    @if($permintaan->status == 'menunggu') bg-secondary
                    @elseif($permintaan->status == 'disetujui') bg-success
                    @else bg-danger
                    @endif">
                    {{ ucfirst($permintaan->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Pemohon:</strong> {{ $permintaan->pemohon->name }}</p>
                        <p class="mb-1"><strong>Tgl Masak:</strong> {{ \Carbon\Carbon::parse($permintaan->tgl_masak)->format('d M Y') }}</p>
                        <p class="mb-1"><strong>Jumlah Porsi:</strong> {{ $permintaan->jumlah_porsi }}</p>
                    </div>
                    <div class="col-md-8">
                        <h6>Bahan yang diminta:</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($permintaan->details as $detail)
                                @if($detail->bahanBaku)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $detail->bahanBaku->nama }}
                                        <span class="badge 
                                            @if($detail->bahanBaku->jumlah < $detail->jumlah_diminta) bg-danger
                                            @else bg-primary
                                            @endif rounded-pill">
                                            Diminta: {{ $detail->jumlah_diminta }} / Stok: {{ $detail->bahanBaku->jumlah }} {{ $detail->bahanBaku->satuan }}
                                        </span>
                                    </li>
                                @else
                                    <li class="list-group-item text-danger fst-italic">
                                        -- Data bahan baku untuk item ini telah dihapus --
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            @if ($permintaan->status == 'menunggu')
                <div class="card-footer text-end bg-light">
                    <form action="{{ route('gudang.permintaan.proses', $permintaan->id) }}" method="POST">
                        @csrf
                        <button type="submit" name="status" value="disetujui" class="btn btn-success me-2">
                            <i class="bi bi-check-circle"></i> Setujui
                        </button>
                        <button type="submit" name="status" value="ditolak" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="alert alert-info">
            Tidak ada data permintaan yang ditemukan.
        </div>
    @endforelse
@endsection

@push('scripts')
{{-- Tambahkan script ini untuk fungsionalitas filter --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('[data-status-filter]');
    const requestCards = document.querySelectorAll('.status-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const status = this.getAttribute('data-status-filter');

            requestCards.forEach(card => {
                if (status === 'semua' || card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush