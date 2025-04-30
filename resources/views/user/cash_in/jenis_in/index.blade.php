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
                                <h2 class="text-white pb-2 fw-bold">Jenis Cash In</h2>
                                <h5 class="text-white op-7 mb-2">Kelola jenis cash in Anda</h5>
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
                                                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Judul, Jenis, atau Deskripsi">
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Icon</th>
                                                    <th>Warna</th>
                                                    <th>Jenis Cash In</th>
                                                    <th>Deskripsi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="jenisInTableBody">
                                                @forelse ($jenisIns as $jenisIn)
                                                    <tr>
                                                        <td><i class="{{ $jenisIn->icon }}" style="color: {{ $jenisIn->color }}; font-size: 30px;"></i></td>
                                                        <td style="background-color: {{ $jenisIn->color }};"></td>
                                                        <td>{{ $jenisIn->title }}</td>
                                                        <td>{{ $jenisIn->description }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-warning edit-button" data-toggle="modal" 
                                                                data-target="#addJenisInModal" data-id="{{ $jenisIn->id }}" 
                                                                data-title="{{ $jenisIn->title }}" data-description="{{ $jenisIn->description }}" 
                                                                data-icon="{{ $jenisIn->icon }}" data-color="{{ $jenisIn->color }}" 
                                                                title="Edit Data">
                                                                    <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('jenis_in.destroy', $jenisIn->id) }}" 
                                                                method="POST" style="display: inline;" title="Hapus Data">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jenis cash in ini?')" 
                                                                    title="Hapus Data">
                                                                        <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data jenis cash in</td>
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
                                    <h5 class="card-title">Form Jenis Cash In</h5>
                                    <form id="jenisInForm" action="{{ route('jenis_in.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="jenisInId" name="id">
                                        <div class="form-group">
                                            <label for="title">Jenis Cash In</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="icon">Ikon</label>
                                            <div id="iconSelection" style="overflow-y: auto; max-height: 100px; display: block; white-space: normal;"></div>
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
        $('#addJenisInModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
            $('#jenisInForm').attr('action', '{{ route('jenis_in.store') }}');
            $('#jenisInForm').find('input[name="_method"]').remove();
            $('#addJenisInModalLabel').text('Tambah Jenis Cash In');
        });

        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var icon = $(this).data('icon');
            var color = $(this).data('color');

            $('#jenisInId').val(id);
            $('#title').val(title);
            $('#description').val(description);
            $('#icon').val(icon);
            $('#color').val(color);
            $('#colorDisplay').css('background-color', color);
            $('#jenisInForm').attr('action', '/jenis_in/' + id);
            $('#jenisInForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#addJenisInModalLabel').text('Edit Jenis Cash In');
        });

        // Fungsi untuk melakukan pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#jenisInTableBody tr');

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
            "fas fa-gift",
            "fas fa-receipt",
            "fas fa-hand-holding-usd",
            "fas fa-money-check-alt",
            "fas fa-piggy-bank",
            "fas fa-coins",
            "fas fa-chart-line",
            "fas fa-chart-pie",
            "fas fa-dollar-sign",
            "fas fa-briefcase",
            "fas fa-store",
            "fas fa-shopping-cart",
            "fas fa-credit-card",
            "fas fa-user-tie",
            "fas fa-building",
            "fas fa-clipboard-list",
            "fas fa-file-invoice-dollar",
            "fas fa-calculator",
            "fas fa-wallet",
            "fas fa-balance-scale",
            "fas fa-handshake",
            "fas fa-people-carry",
            "fas fa-suitcase",
            "fas fa-archive",
            "fas fa-tags",
            "fas fa-clipboard-check",
            "fas fa-chart-bar",
            "fas fa-comments-dollar",
            "fas fa-clipboard"
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