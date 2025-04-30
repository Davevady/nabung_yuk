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
                                <h5 class="text-white op-7 mb-2">Kelola target Anda</h5>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addTargetModal">Tambah Target</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Tambahkan input pencarian -->
                                    {{-- <div class="col-md-4 ml-auto">
                                        <div class="mb-3">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Judul, Jenis, atau Deskripsi">
                                        </div>
                                    </div> --}}
                                    <div class="row mt--2">
                                        @forelse ($targets as $target)
                                            <div class="col-md-4 mb-4">
                                                <div class="card shadow-sm" style="border-radius: 10px;">
                                                    @php
                                                        $mediaArray = json_decode($target->media, true);
                                                    @endphp
                                                    <div id="mediaCarousel{{ $target->id }}" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @if ($mediaArray && is_array($mediaArray) && count($mediaArray) > 0)
                                                                @foreach ($mediaArray as $index => $media)
                                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset($media) }}" alt="Media" 
                                                                            style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;" 
                                                                            class="thumbnail" data-toggle="modal" data-target="#imageModal" 
                                                                            data-image="{{ asset($media) }}" data-id="{{ $target->id }}">
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="carousel-item active">
                                                                    <div class="text-center" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                                                        <span>Tidak ada media</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <a class="carousel-control-prev" href="#mediaCarousel{{ $target->id }}" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Sebelumnya</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#mediaCarousel{{ $target->id }}" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Selanjutnya</span>
                                                        </a>
                                                    </div>
                                                    <button type="button" class="btn btn-info btn-sm add-media-button" 
                                                        data-toggle="modal" data-target="#addMediaModal" data-id="{{ $target->id }}" 
                                                        data-media="{{ json_encode($target->media) }}" title="Tambah Media" 
                                                        style="position: absolute; z-index: 10; top: 10px; right: 10px;">
                                                            <i class="fas fa-plus"></i>
                                                    </button>
                                                    <div class="card-body">
                                                        <h5 class="card-title" style="font-size: 1.25rem; font-weight: bold;">{{ $target->title }}</h5>
                                                        <h5 class="card-title" style="font-size: 1rem;">
                                                            @php
                                                                $tanggalTarget = \Carbon\Carbon::parse($target->tanggal_target);
                                                                $warna = $tanggalTarget->isPast() ? 'red' : 'black';
                                                                $status = $tanggalTarget->isPast() ? '(sudah lewat)' : '(masih berlaku)';
                                                            @endphp
                                                            <span style="color: {{ $warna }};">
                                                                {{ $tanggalTarget->format('d F Y') }} 
                                                            </span>
                                                            <span class="text-muted" style="font-size: 0.8rem; color: {{ $warna }};"> {{ $status }}</span>
                                                        </h5>
                                                        <p class="card-text"><strong>Rp {{ number_format($target->jumlah_tercapai, 0, ',', '.') }} / Rp {{ number_format($target->jumlah_target, 0, ',', '.') }}</strong></p>
                                                        <div class="progress mb-2">
                                                            <div class="progress-bar" role="progressbar" style="width: {{ ($target->jumlah_tercapai / $target->jumlah_target) * 100 }}%; background-color: #007bff;" aria-valuenow="{{ $target->jumlah_tercapai }}" aria-valuemin="0" aria-valuemax="{{ $target->jumlah_target }}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <div class="alert alert-warning text-center">Tidak ada data target</div>
                                            </div>
                                        @endforelse
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
    <div class="modal fade" id="addTargetModal" tabindex="-1" role="dialog" aria-labelledby="addTargetModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTargetModalLabel">Tambah Target</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="targetForm" action="{{ route('tujuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="targetId" name="id">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_target">Jumlah Target</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="jumlah_target" name="jumlah_target" placeholder="Masukkan jumlah target" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">,00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_target">Tanggal Target</label>
                            <input type="date" class="form-control" id="tanggal_target" name="tanggal_target" placeholder="Masukkan tanggal target" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="media">Media</label>
                            <input type="file" class="form-control" id="media" name="media[]" multiple accept="image/*">
                            @if(isset($target) && $target->media)
                                <div id="previousMediaContent"></div>
                            @endif
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
                        <input type="hidden" id="targetId" name="targetId">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function formatRupiah(angka) {
        var number_string = angka.toString().replace(/[^0-9]/g, '');
        var rupiah = '';
        var ribuan = number_string.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        return ribuan ? ribuan : '';
    }

    $(document).ready(function() {
        $('#addTargetModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#targetForm').attr('action', '{{ route('tujuan.store') }}');
            $('#targetForm').find('input[name="_method"]').remove();
            $('#addTargetModalLabel').text('Tambah Target');
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
        });

        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var jumlah_target = $(this).data('jumlah_target');
            var jumlah_tercapai = $(this).data('jumlah_tercapai');
            var sisa_target = $(this).data('sisa_target');
            var tanggal_target = $(this).data('tanggal_target');
            var description = $(this).data('description');
            var media = $(this).data('media');

            $('#targetId').val(id);
            $('#title').val(title);
            $('#jumlah_target').val(formatRupiah(jumlah_target)); // Format jumlah menjadi rupiah
            $('#tanggal_target').val(tanggal_target);
            $('#description').val(description);
            $('#targetForm').attr('action', '/tujuan/' + id);
            $('#targetForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#addTargetModalLabel').text('Edit Target');

            // Tampilkan media sebelumnya
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
            if (media) {
                media.forEach(function(item) {
                    $('#previousMediaContent').append('<img src="' + item + '" class="thumbnail" data-image="' + item + '" style="width: 100px; margin: 5px;">');
                });
            }
            // Tampilkan text "Kosongkan jika tidak ingin mengubah media"
            $('#previousMediaContent').append('<p class="mt-2">Kosongkan jika tidak ingin mengubah media</p>');
        });

        document.getElementById('jumlah_target').addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
        });

        document.getElementById('jumlah_target').addEventListener('blur', function(e) {
            if (this.value === 'Rp. ') {
                this.value = '';
            }
        });

        // Ketika gambar diklik, set src modal dengan src gambar yang diklik
        $('.thumbnail').on('click', function() {
            var imageSrc = $(this).data('image');
            $('#modalImage').attr('src', imageSrc);
        });

        // Ketika tombol "Tambah Media" diklik
        $('.add-media-button').on('click', function() {
            var targetId = $(this).data('id');
            $('#targetId').val(targetId); // Set ID target ke input hidden
            $('#mediaForm').attr('action', '/tujuan/' + targetId + '/update_media'); // Set action form
            
            // Tampilkan media sebelumnya
            var media = $(this).data('media'); // Ambil data media dari atribut
            $('#previousMediaContent').empty(); // Menghapus media sebelumnya
            if (media) {
                media.forEach(function(item) {
                    $('#previousMediaContent').append('<img src="' + item + '" class="thumbnail" data-image="' + item + '" style="width: 100px; margin: 5px;">');
                });
            }
        });

        // Mengubah format jumlah sebelum mengirimkan form
        $('#targetForm').on('submit', function() {
            var jumlahInput = $('#jumlah_target');
            var jumlahValue = jumlahInput.val().replace(/[^0-9]/g, ''); // Menghapus format rupiah
            jumlahInput.val(jumlahValue); // Set nilai input menjadi integer
        });

        // Fungsi untuk melakukan pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#targetTableBody tr');

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
