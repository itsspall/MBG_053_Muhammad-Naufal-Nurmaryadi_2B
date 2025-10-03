<script>
    // Menangani pesan sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    // Menangani pesan error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}'
        });
    @endif
    
    // Menangani error validasi dari form
    @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += `<li>{{ $error }}</li>`;
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Oops, terjadi kesalahan!',
            html: `<ul>${errorMessages}</ul>`
        });
    @endif
</script>