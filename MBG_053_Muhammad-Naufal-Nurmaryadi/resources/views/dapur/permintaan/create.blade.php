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

@push('scripts')
<script>
    // Mengubah data PHP dari controller menjadi variabel JavaScript
    const bahanTersedia = @json($bahanTersedia);
    let rowIndex = 0;

    document.getElementById('add-bahan').addEventListener('click', function() {
        // Buat baris tabel baru (tr)
        const tr = document.createElement('tr');
        
        // Buat dropdown (select) untuk nama bahan
        let selectHtml = `<select name="bahan[${rowIndex}][id]" class="form-select" required>`;
        selectHtml += `<option value="">-- Pilih Bahan --</option>`;
        bahanTersedia.forEach(bahan => {
            selectHtml += `<option value="${bahan.id}">${bahan.nama} (Stok: ${bahan.jumlah} ${bahan.satuan})</option>`;
        });
        selectHtml += `</select>`;

        // Buat input untuk jumlah
        const jumlahInput = `<input type="number" name="bahan[${rowIndex}][jumlah]" class="form-control" required min="1">`;
        
        // Buat tombol hapus
        const deleteButton = `<button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>`;

        // Gabungkan semua elemen ke dalam baris
        tr.innerHTML = `
            <td>${selectHtml}</td>
            <td>${jumlahInput}</td>
            <td>${deleteButton}</td>
        `;

        // Tambahkan baris baru ke dalam tabel
        document.getElementById('bahan-list').appendChild(tr);
        rowIndex++; // Naikkan index untuk baris berikutnya
    });

    // Event listener untuk tombol hapus (menggunakan event delegation)
    document.getElementById('bahan-list').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-row')) {
            // Hapus baris (tr) tempat tombol hapus diklik
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush