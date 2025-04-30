<!DOCTYPE html>
<html lang="en">
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
                                <h2 class="text-white pb-2 fw-bold">Jenis Cash Out</h2>
                                <h5 class="text-white op-7 mb-2">Kelola jenis cash out Anda</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- Tambahkan input pencarian -->
                                        <div class="col-md-4 ml-auto">
                                            <div class="mb-3">
                                                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Judul atau Deskripsi">
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Icon</th>
                                                    <th>Warna</th>
                                                    <th>Jenis Cash Out</th>
                                                    <th>Deskripsi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="jenisOutTableBody">
                                                @forelse ($jenisOuts as $jenisOut)
                                                    <tr>
                                                        <td><i class="{{ $jenisOut->icon }}" style="color: {{ $jenisOut->color }}; font-size: 30px;"></i></td>
                                                        <td style="background-color: {{ $jenisOut->color }};"></td>
                                                        <td>{{ $jenisOut->title }}</td>
                                                        <td>{{ $jenisOut->description }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-warning edit-button" data-toggle="modal" 
                                                                data-target="#addJenisOutModal" data-id="{{ $jenisOut->id }}" 
                                                                data-title="{{ $jenisOut->title }}" data-description="{{ $jenisOut->description }}" 
                                                                data-icon="{{ $jenisOut->icon }}" data-color="{{ $jenisOut->color }}" 
                                                                title="Edit Data">
                                                                    <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('jenis_out.destroy', $jenisOut->id) }}" 
                                                                method="POST" style="display: inline;" title="Hapus Data">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jenis cash out ini?')" 
                                                                    title="Hapus Data">
                                                                        <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data jenis cash out</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Jenis Cash Out</h5>
                                    <form id="jenisOutForm" action="{{ route('jenis_out.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="jenisOutId" name="id">
                                        <div class="form-group">
                                            <label for="title">Jenis Cash Out</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="icon">Ikon</label>
                                            <div id="iconSelection" style="display: flex; flex-wrap: wrap;"></div>
                                            <div id="selectedIcon" style="margin-top: 10px;">
                                                <p>Ikon default:</p>
                                                <i class="fas fa-money-bill" style="font-size: 30px;"></i> <!-- Ikon default -->
                                            </div>
                                            <input type="hidden" id="icon" name="icon" required value="fas fa-money-bill">
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Warna</label>
                                            <div class="d-flex align-items-center">
                                                <div id="colorDisplay" style="width: 30px; height: 30px; border: 1px solid #ccc; margin-right: 10px;" onclick="document.getElementById('color').click();"></div>
                                                <input type="color" class="form-control" id="color" name="color" required onclick="this.click();">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
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
</body>
<script>
    $(document).ready(function() {
        $('#addJenisOutModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#jenisOutForm').attr('action', '{{ route('jenis_out.store') }}');
            $('#jenisOutForm').find('input[name="_method"]').remove();
            $('#addJenisOutModalLabel').text('Tambah Jenis Cash Out');
        });

        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var icon = $(this).data('icon');
            var color = $(this).data('color');

            $('#jenisOutId').val(id);
            $('#title').val(title);
            $('#description').val(description);
            $('#icon').val(icon);
            $('#selectedIcon').html('<p>Ikon sebelumnya:</p><i class="' + icon + '" style="font-size: 30px;"></i>');
            $('#color').val(color);
            $('#colorDisplay').css('background-color', color);

            $('#jenisOutForm').attr('action', '/jenis_out/' + id);
            $('#jenisOutForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#addJenisOutModalLabel').text('Edit Jenis Cash Out');
        });

        // Fungsi untuk melakukan pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#jenisOutTableBody tr');

            rows.forEach(function(row) {
                var title = row.cells[1].textContent.toLowerCase();
                var description = row.cells[2].textContent.toLowerCase();

                if (title.includes(input) || description.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        $('#color').on('input', function() {
            let hexColor = $(this).val();
            $('#colorDisplay').css('background-color', hexColor); // Menampilkan warna yang dipilih
        });

        // Daftar ikon
        const icons = [
            "fas fa-money-bill",
            "fas fa-credit-card",
            "fas fa-wallet",
            "fas fa-car",
            "fas fa-bus",
            "fas fa-plane",
            "fas fa-train",
            "fas fa-ship",
            "fas fa-shopping-cart",
            "fas fa-shopping-basket",
            "fas fa-shopping-bag",
            "fas fa-utensils",
            "fas fa-coffee",
            "fas fa-gift",
            "fas fa-tshirt",
            "fas fa-home",
            "fas fa-tools",
            "fas fa-birthday-cake",
            "fas fa-futbol",
            "fas fa-gamepad",
            "fas fa-camera",
            "fas fa-book",
            "fas fa-laptop",
            "fas fa-mobile-alt",
            "fas fa-bicycle",
            "fas fa-bus-alt",
            "fas fa-umbrella",
            "fas fa-snowflake",
            "fas fa-bell",
            "fas fa-heart",
            "fas fa-star",
            "fas fa-lightbulb",
            "fas fa-paint-brush",
            "fas fa-socks",
            "fas fa-apple-alt"
        ];

        // Tambahkan ikon ke dalam elemen
        icons.forEach(icon => {
            $('#iconSelection').append(
                `<i class="${icon}" style="font-size: 30px; margin: 5px; cursor: pointer;" data-icon="${icon}"></i>`
            );
        });

        // Event listener untuk ikon yang dipilih
        $('#iconSelection i').on('click', function() {
            let selectedIcon = $(this).data('icon');
            $('#selectedIcon').html('<p>Ikon yang dipilih:</p><i class="' + selectedIcon + '" style="font-size: 30px;"></i>');
            $('#icon').val(selectedIcon); // Mengupdate input tersembunyi dengan ikon yang dipilih
        });
    });
</script>
</html>