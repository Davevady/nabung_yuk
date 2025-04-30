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
                                <h5 class="text-white op-7 mb-2">Kelola keuangan Anda</h5>
                            </div>
                            {{-- <div class="ml-auto">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addCashOutModal">Tambah Cash Out</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-header">
                                    <p class="card-title text-center" style="font-size: 1rem;">Target</p>
                                </div>
                                <div class="card-body">
                                    <div class="text-right mb-4">
                                        <a href="/tujuan">Lihat Semua <i class="fas fa-chevron-circle-right" style="margin-left: 5px;"></i></a>
                                    </div>
                                    @forelse ($targets as $target)
                                        @php
                                            $tanggalTarget = \Carbon\Carbon::parse($target->tanggal_target);
                                        @endphp
                                        @if (!$tanggalTarget->isPast())
                                            <div class="col-md-6 mb-4">
                                                <div class="card shadow-sm">
                                                    @php
                                                        $mediaArray = json_decode($target->media, true);
                                                    @endphp
                                                    <div id="mediaCarousel{{ $target->id }}" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @if ($mediaArray && is_array($mediaArray) && count($mediaArray) > 0)
                                                                @foreach ($mediaArray as $index => $media)
                                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset($media) }}" alt="Media" 
                                                                            style="width: 100%; height: 150px; object-fit: cover; border-radius: 6px;" 
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
                                                    <div class="card-body">
                                                        <h5 class="card-title" style="font-size: 1.25rem; font-weight: bold;">{{ $target->title }}</h5>
                                                        <h5 class="card-title" style="font-size: 1rem;">
                                                            <span style="color: black;">{{ $tanggalTarget->format('d F Y') }}</span>
                                                            <span class="text-muted" style="font-size: 0.8rem;"> sisa {{ $tanggalTarget->diffInDays(\Carbon\Carbon::now()) }} hari lagi</span>
                                                        </h5>
                                                        <p class="card-text"><strong>Rp {{ number_format($target->jumlah_tercapai, 0, ',', '.') }} / Rp {{ number_format($target->jumlah_target, 0, ',', '.') }}</strong></p>
                                                        <div class="progress mb-2">
                                                            <div class="progress-bar" role="progressbar" style="width: {{ ($target->jumlah_tercapai / $target->jumlah_target) * 100 }}%; background-color: #007bff;" aria-valuenow="{{ $target->jumlah_tercapai }}" aria-valuemin="0" aria-valuemax="{{ $target->jumlah_target }}"></div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#inputModal{{ $target->id }}" style="border-radius: 8px;">
                                                            Masukkan uang ke celengan
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="col-md-12">
                                            <div class="alert alert-warning text-center">Tidak ada data target</div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="fw-bold text-center mb-4">Total Aset</h2>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-money-bill-wave" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <h5 class="mb-0">Uang Dingin</h5>
                                        </div>
                                        <p id="totalSaldo" style="font-size: 1.5rem;" class="fw-bold mb-0">
                                            Rp {{ number_format($cashIns->sum('jumlah') - $targets->sum('jumlah_tercapai') - $cashOuts->sum('jumlah'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-piggy-bank" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                            <h5 class="mb-0">Tabungan</h5>
                                        </div>
                                        <p id="totalTabungan" style="font-size: 1.5rem;" class="fw-bold mb-0">
                                            Rp {{ number_format($targets->sum('jumlah_tercapai'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="fw-bold mb-4 text-center">Grafik Keuangan</h2>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <p class="card-title text-center" style="font-size: 1rem;">Uang Masuk</p>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="pieChart1" 
                                                        style="width: 100%; height: 300px;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <p class="card-title text-center" style="font-size: 1rem;">Uang Keluar</p>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="pieChart2" 
                                                        style="width: 100%; height: 300px;"></canvas>
                                                </div>
                                            </div>
                                        </div>
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

    @foreach ($targets as $target)
        @php
            $tanggalTarget = \Carbon\Carbon::parse($target->tanggal_target);
        @endphp
        @if (!$tanggalTarget->isPast())
            <!-- Modal -->
            <div class="modal fade" id="inputModal{{ $target->id }}" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel{{ $target->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inputModalLabel{{ $target->id }}"> {{ $target->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('keuangan.verifikasi_target', $target->id) }}" method="POST" onsubmit="removeCurrencyFormat('{{ $target->id }}')">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="inputAngka{{ $target->id }}">Masukkan Angka</label>
                                    <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 3px;">Sisa Target : Rp {{ number_format($target->sisa_target, 0, ',', '.') }}</p>
                                    <p class="text-muted" style="font-size: 0.8rem; margin-bottom: 5px;">Uang Dingin : Rp {{ number_format($cashIns->sum('jumlah') - $targets->sum('jumlah_tercapai') - $cashOuts->sum('jumlah'), 0, ',', '.') }}</p>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="inputAngka" class="form-control" id="inputAngka{{ $target->id }}" placeholder="Masukkan angka" required 
                                            max="{{ $cashIns->sum('jumlah') - $targets->sum('jumlah_tercapai') - $cashOuts->sum('jumlah') }}" 
                                            oninput="this.value = formatRupiah(this.value); 
                                                if (parseInt(this.value.replace(/[^0-9]/g, '')) > {{ $cashIns->sum('jumlah') - $targets->sum('jumlah_tercapai') - $cashOuts->sum('jumlah') }}) {
                                                    this.value = formatRupiah({{ $cashIns->sum('jumlah') - $targets->sum('jumlah_tercapai') - $cashOuts->sum('jumlah') }});
                                                }">
                                        <div class="input-group-append">
                                            <span class="input-group-text">,00</span>
                                        </div>
                                    </div>
                                    <p class="text-muted" style="font-size: 0.8rem; margin-top: 5px;">Tidak boleh melebihi uang dingin</p>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</body>
<script>
    function formatRupiah(angka) {
        var number_string = angka.toString().replace(/[^0-9]/g, '');
        var rupiah = '';
        var ribuan = number_string.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        return ribuan ? ribuan : '';
    }

    function removeCurrencyFormat(targetId) {
        var inputField = document.getElementById('inputAngka' + targetId);
        inputField.value = inputField.value.replace(/[^0-9]/g, ''); // Menghilangkan format uang
    }

    var cashInData = @json($cashIns->groupBy('jenisIn')->map(function ($items) {
        return $items->sum('jumlah');
    }));
    var cashOutData = @json($cashOuts->groupBy('jenisOut')->map(function ($items) {
        return $items->sum('jumlah');
    }));
    var totalTarget = @json($targets->sum('jumlah_target'));
    console.log('Data Cash In:', cashInData);
    console.log('Data Cash Out:', cashOutData);
    console.log('Total Target:', totalTarget);

    var pieChart1 = document.getElementById('pieChart1').getContext('2d');
    var pieChart2 = document.getElementById('pieChart2').getContext('2d');

    // Menghitung total cash in untuk persentase
    var totalCashIn = Object.values(cashInData).reduce((a, b) => a + b, 0) || 1; // Menghindari pembagian dengan nol

    var myPieChart1 = new Chart(pieChart1, {
        type: 'pie',
        data: {
            datasets: [{
                data: Object.values(cashInData).map(value => (value / totalCashIn) * 100), // Menghitung persentase
                backgroundColor: ["#1d7af3", "#f3545d", "#28a745"], // Tambahkan warna sesuai jumlah jenis_in
                borderWidth: 0
            }],
            labels: Object.keys(cashInData).map(key => JSON.parse(key).title) // Mengambil label dari jenis_in
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: 'rgb(154, 154, 154)',
                    fontSize: 11,
                    usePointStyle: true,
                    padding: 20
                }
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: 'white',
                fontSize: 14,
            },
            tooltips: false,
            layout: {
                padding: {
                    left: 20,
                    right: 20,
                    top: 20,
                    bottom: 20
                }
            }
        }
    });

    var myPieChart2 = new Chart(pieChart2, {
        type: 'pie',
        data: {
            datasets: [{
                data: Object.values(cashOutData),
                backgroundColor: ["#f3545d", "#1d7af3"], // Tambahkan warna sesuai jumlah jenis_out
                borderWidth: 0
            }],
            labels: Object.keys(cashOutData).map(key => JSON.parse(key).title) // Mengambil label dari jenis_out
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
                labels: {
                    fontColor: 'rgb(154, 154, 154)',
                    fontSize: 11,
                    usePointStyle: true,
                    padding: 20
                }
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: 'white',
                fontSize: 14,
            },
            tooltips: false,
            layout: {
                padding: {
                    left: 20,
                    right: 20,
                    top: 20,
                    bottom: 20
                }
            }
        }
    });
</script>
</html>
<!-- End Generation Here -->
