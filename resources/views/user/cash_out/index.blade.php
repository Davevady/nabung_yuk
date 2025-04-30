<!-- Start Generation Here -->
<!DOCTYPE html>
<html lang="id">
<head>
    @include('layout.user.head')
</head>
<body>
    <div class="wrapper">
        @include('layout.user.header')
        @include('layout.user.alert')

        <!-- Sidebar -->
        @include('layout.user.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white pb-2 fw-bold">{{ $title }}</h2>
                                <h5 class="text-white op-7 mb-2">Kelola uang keluar Anda</h5>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addCashOutModal">Tambah Uang Keluar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- Tambahkan input pencarian -->
                                        <div class="col-md-4 ml-auto">
                                            <div class="mb-3">
                                                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Judul, Jenis, atau Deskripsi">
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Waktu</th>
                                                    <th>Media</th>
                                                    <th>Jenis Uang Keluar <a href="{{ route('jenis_out.index') }}" class="text-primary" title="Lihat Jenis Out" style="margin-left: 10px;"><i class="fas fa-list" style="color: black;"></i></a></th>
                                                    <th>Judul</th>
                                                    <th>Jumlah</th>
                                                    <th>Deskripsi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cashOutTableBody">
                                                @forelse ($cashOuts as $cashOut)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($cashOut->tanggal)->format('d F Y') }} - {{ \Carbon\Carbon::parse($cashOut->jam)->format('H:i') }}</td>
                                                        <td>
                                                            @php
                                                                $mediaArray = json_decode($cashOut->media, true);
                                                            @endphp
                                                            @if ($mediaArray && is_array($mediaArray))
                                                                @foreach ($mediaArray as $media)
                                                                    <img src="{{ asset($media) }}" alt="Media" 
                                                                        style="width: 50px; height: 50px; margin-right: 5px; border-radius: 5px; object-fit: cover;" 
                                                                        class="thumbnail" data-toggle="modal" data-target="#imageModal" 
                                                                        data-image="{{ asset($media) }}" data-id="{{ $cashOut->id }}">
                                                                @endforeach
                                                            @else
                                                                Tidak ada media
                                                            @endif
                                                            <button type="button" class="btn btn-xs btn-primary add-media-button" 
                                                                data-toggle="modal" data-target="#addMediaModal" data-id="{{ $cashOut->id }}" 
                                                                data-media="{{ json_encode($mediaArray) }}" title="Tambah Media">
                                                                    <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                        <td>{{ $cashOut->jenisOut->title }}</td>
                                                        <td>{{ $cashOut->title }}</td>
                                                        <td>
                                                            Rp {{ number_format($cashOut->jumlah, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $cashOut->description }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-warning edit-button" data-toggle="modal" 
                                                                data-target="#addCashOutModal" data-id="{{ $cashOut->id }}" 
                                                                data-title="{{ $cashOut->title }}" data-jumlah="{{ $cashOut->jumlah }}" 
                                                                data-description="{{ $cashOut->description }}" data-media="{{ json_encode($mediaArray) }}" 
                                                                data-jenis-out-id="{{ $cashOut->jenis_out_id }}" title="Edit Data">
                                                                    <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('cash_out.destroy', $cashOut->id) }}" 
                                                                method="POST" style="display: inline;" title="Hapus Data">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus uang keluar ini?')" 
                                                                    title="Hapus Data">
                                                                        <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Tidak ada data uang keluar</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('layout.user.footer')
            @include('layout.user.script')
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCashOutModal" tabindex="-1" role="dialog" aria-labelledby="addCashOutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCashOutModalLabel">Tambah Uang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cashOutForm" action="{{ route('cash_out.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="cashOutId" name="id">
                        <div class="form-group">
                            <label for="title">Dipake buat apa?</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Berapa?</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_out_id">Jenis pengeluaran apa?</label>
                            <select class="form-control" id="jenis_out_id" name="jenis_out_id" required>
                                <option value="" selected disabled>Pilih jenis uang keluar</option>
                                @foreach ($jenisOuts as $jenisOut)
                                    <option value="{{ $jenisOut->id }}">{{ $jenisOut->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Ceritain lebih detail disini</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="media">Foto pendukung</label>
                            <input type="file" class="form-control" id="media" name="media[]" multiple accept="image/*">
                            <small class="text-muted">Gabisa lebih dari 2MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Media" style="width: 100%; height: auto;">
                    <button id="deleteImageButton" class="btn btn-danger mt-2" style="display: none;">Hapus Gambar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambahkan media -->
    <div class="modal fade" id="addMediaModal" tabindex="-1" role="dialog" aria-labelledby="addMediaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMediaModalLabel">Tambah Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="mediaForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Menggunakan PUT untuk update -->
                        <input type="hidden" id="cashOutId" name="cashOutId">
                        <div class="form-group">
                            <label>Media Sebelumnya</label>
                            <div id="previousMedia">
                                <!-- Menampilkan media sebelumnya sesuai dengan data yang dipilih -->
                                <div id="previousMediaContent"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="media">Pilih Media</label>
                            <input type="file" class="form-control" id="media" name="media[]" multiple accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Media</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function formatRupiah(angka) {
        var number_string = angka.toString().replace(/[^0-9]/g, '');
        var rupiah = '';
        var ribuan = number_string.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        return ribuan ? 'Rp. ' + ribuan : '';
    }

    $(document).ready(function() {
        $('#addCashOutModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#cashOutForm').attr('action', '{{ route('cash_out.store') }}');
            $('#cashOutForm').find('input[name="_method"]').remove();
            $('#addCashOutModalLabel').text('Tambah Uang Keluar');
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
        });

        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var jumlah = $(this).data('jumlah');
            var description = $(this).data('description');
            var media = $(this).data('media');
            var jenisOutId = $(this).data('jenis-out-id'); // Ambil jenis out id

            $('#cashOutId').val(id);
            $('#title').val(title);
            $('#jumlah').val(formatRupiah(jumlah)); // Format jumlah menjadi rupiah
            $('#description').val(description);
            $('#cashOutForm').attr('action', '/cash_out/' + id);
            $('#cashOutForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#addCashOutModalLabel').text('Edit Uang Keluar');

            // Set jenis uang keluar yang dipilih
            $('#jenis_out_id').val(jenisOutId);

            // Tampilkan media sebelumnya
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
            if (media) {
                media.forEach(function(item) {
                    $('#previousMediaContent').append('<img src="' + item + '" class="thumbnail" data-image="' + item + '" style="width: 100px; margin: 5px;">');
                });
            }
        });

        document.getElementById('jumlah').addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
        });

        document.getElementById('jumlah').addEventListener('blur', function(e) {
            if (this.value === 'Rp. ') {
                this.value = '';
            }
        });

        // Ketika gambar diklik, set src modal dengan src gambar yang diklik
        $('.thumbnail').on('click', function() {
            var imageSrc = $(this).data('image').replace('http://127.0.0.1:8000/', ''); // Menghapus URL dasar
            var cashOutId = $(this).data('id'); // Ambil ID uang keluar dari thumbnail
            $('#modalImage').attr('src', imageSrc);
            $('#deleteImageButton').data('image', imageSrc).data('cashOutId', cashOutId).show(); // Simpan src gambar dan ID uang keluar di tombol hapus
        });

        // Ketika tombol hapus diklik
        $('#deleteImageButton').on('click', function() {
            var imageSrc = $(this).data('image');
            var cashOutId = $(this).data('cashOutId'); // Ambil ID uang keluar

            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                $.ajax({
                    url: '/cash_out/' + cashOutId + '/destroy_media', // Rute untuk menghapus media
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        media: imageSrc
                    },
                    success: function(response) {
                        alert(response.success);
                        $('#imageModal').modal('hide'); // Tutup modal setelah berhasil
                        location.reload(); // Reload halaman untuk memperbarui daftar gambar
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal menghapus media: ' + xhr.responseJSON.error);
                    }
                });
            }
        });

        // Ketika tombol "Tambah Media" diklik
        $('.add-media-button').on('click', function() {
            var cashOutId = $(this).data('id');
            $('#cashOutId').val(cashOutId); // Set ID cashOut ke input hidden
            $('#mediaForm').attr('action', '/cash_out/' + cashOutId + '/update_media'); // Set action form
            
            // Tampilkan media sebelumnya
            var media = $(this).data('media'); // Ambil data media dari atribut
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
            if (media) {
                media.forEach(function(item) {
                    $('#previousMediaContent').append('<img src="' + item + '" class="thumbnail" data-image="' + item + '" style="width: 100px; margin: 5px;">');
                });
            }
        });

        // Mengubah format jumlah menjadi integer sebelum mengirimkan form
        $('#cashOutForm').on('submit', function() {
            var jumlahInput = $('#jumlah');
            var jumlahValue = jumlahInput.val().replace(/[^0-9]/g, ''); // Menghapus format rupiah
            jumlahInput.val(jumlahValue); // Set nilai input menjadi integer
        });

        // Fungsi untuk melakukan pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#cashOutTableBody tr');

            rows.forEach(function(row) {
                var title = row.cells[1].textContent.toLowerCase();
                var jenis = row.cells[2].textContent.toLowerCase();
                var description = row.cells[5].textContent.toLowerCase();

                if (title.includes(input) || jenis.includes(input) || description.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
