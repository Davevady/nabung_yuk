<!DOCTYPE html>
<html lang="en">
<head>
	@include('layout.user.head')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>
		#circles-1, #circles-2, #circles-3 {
			width: 100%;
			height: 50px; /* Atur tinggi sesuai kebutuhan */
		}

		.card {
			max-height: 500px; /* Atur tinggi maksimum untuk card */
			overflow: hidden; /* Sembunyikan konten yang meluap */
		}

		.card-body {
			display: flex;
			flex-direction: column; /* Atur arah flex menjadi kolom */
			justify-content: space-between; /* Ruang antara elemen */
		}
	</style>
</head>
<body>
	<div class="wrapper">
		@include('layout.user.header')

		<!-- Sidebar -->
		@include('layout.user.sidebar')
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
								<h5 class="text-white op-7 mb-2">Selamat datang kembali di NabungYuk</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<a href="#" class="btn btn-white btn-border btn-round mr-2">Kelola Tabungan</a>
								<a href="#" class="btn btn-secondary btn-round">Tambah Target</a>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-8">
							<div class="card">
								<div class="card-body">
									<div class="card-title text-center fw-bold mb-3">Statistik Pengeluaran Satu Minggu Terakhir</div>
										<div class="align-items-center text-center">
											<h6 class="fw-bold text-uppercase text-danger op-8">Total Pengeluaran</h6>
											<h3 class="fw-bold" style="font-size: 2rem;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
										</div>
									<canvas id="dailyChart" style="display: block; height: 300px; max-height: 500px;"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-warning">
								<div class="card-header">
									<div class="card-title">Pengeluaran Hari Ini</div>
									<div class="card-category">{{ \Carbon\Carbon::now()->subDays(7)->format('d F') }} - {{ \Carbon\Carbon::now()->format('d F') }}</div>
								</div>
								<div class="card-body pb-0">
									<div class="mb-4 mt-2">
										<h1>Rp {{ number_format($expenseOfDay->sum('jumlah'), 0, ',', '.') }}</h1>
									</div>
									<div class="pull-in">
										<canvas id="dailySavingsChart"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Target Tabungan Teratas</div>
								</div>
								<div class="card-body pb-0">
									@foreach($targets->sortByDesc('jumlah_target') as $target)
										<div class="d-flex">
											<div class="avatar">
												<img src="{{ asset(json_decode($target->media)[0]) }}" alt="..." class="avatar-img rounded-circle">
											</div>
											<div class="flex-1 pt-1 ml-2">
												<h6 class="fw-bold mb-1">{{ $target->title }}</h6>
												<small class="text-muted">Target: Rp {{ number_format($target->jumlah_target, 0, ',', '.') }}</small>
											</div>
											<div class="d-flex ml-auto align-items-center">
												<h3 class="text-info fw-bold">{{ number_format(($target->jumlah_tercapai / $target->jumlah_target) * 100, 0) }}%</h3>
											</div>
										</div>
										<div class="separator-dashed"></div>
									@endforeach
									<div class="pull-in">
										<canvas id="topProductsChart"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<div class="card-title fw-mediumbold">Rekomendasi Investasi</div>
									<div class="card-list">
										<div class="item-list">
											<div class="avatar">
												<img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle">
											</div>
											<div class="info-user ml-3">
												<div class="username">Reksadana Saham</div>
												<div class="status">Return: 12% p.a</div>
											</div>
											<button class="btn btn-icon btn-primary btn-round btn-xs">
												<i class="fa fa-plus"></i>
											</button>
										</div>
										<div class="item-list">
											<div class="avatar">
												<img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle">
											</div>
											<div class="info-user ml-3">
												<div class="username">Obligasi Pemerintah</div>
												<div class="status">Return: 6% p.a</div>
											</div>
											<button class="btn btn-icon btn-primary btn-round btn-xs">
												<i class="fa fa-plus"></i>
											</button>
										</div>
										<div class="item-list">
											<div class="avatar">
												<img src="../assets/img/talha.jpg" alt="..." class="avatar-img rounded-circle">
											</div>
											<div class="info-user ml-3">
												<div class="username">Deposito</div>
												<div class="status">Return: 4% p.a</div>
											</div>
											<button class="btn btn-icon btn-primary btn-round btn-xs">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-primary bg-primary-gradient">
								<div class="card-body">
									<h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Aktivitas Tabungan</h4>
									<h1 class="mb-4 fw-bold">{{ $cashIns->count() }} Transaksi</h1>
									<h4 class="mt-3 b-b1 pb-2 mb-5 fw-bold">Hari Ini</h4>
									<div id="activeUsersChart"></div>
									<h4 class="mt-5 pb-3 mb-0 fw-bold">Transaksi Terbesar</h4>
									<ul class="list-unstyled">
										<li class="d-flex align-items-center">
											<div class="avatar">
												<img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle">
											</div>
											@php
												$largestCashIn = $cashIns->sortByDesc('jumlah')->first();
											@endphp
											<div class="flex-1 pt-1 ml-2">
												<h6 class="fw-bold mb-1">{{ $largestCashIn->jenis_in }}</h6>
												<smallstyle="color: white;">Rp {{ number_format($largestCashIn->jumlah, 0, ',', '.') }}</smallstyle=>
											</div>
											<div class="d-flex ml-auto align-items-center">
												<h3 class="text-info fw-bold">Rp {{ number_format($largestCashIn->jumlah, 0, ',', '.') }}</h3>
											</div>
										</li>
									</ul>
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
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const dailyExpense = @json($dailyExpenseInitialized);

			const ctx = document.getElementById('dailyChart').getContext('2d');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['SN', 'SL', 'R', 'K', 'J', 'S', 'M'], // Label hari
					datasets: [
						@foreach($jenisOuts as $jenisOut)
						{
							label: '{{ $jenisOut->title }}', // Mengambil label dari jenisOut
							data: [
								dailyExpense['Sun']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Mon']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Tue']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Wed']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Thu']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Fri']['{{ $jenisOut->id }}'] || 0,
								dailyExpense['Sat']['{{ $jenisOut->id }}'] || 0,
							], // Data pengeluaran per jenis
							backgroundColor: '{{ $jenisOut->color }}', // Warna batang merah
						},
						@endforeach
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: true,
					legend: {
						display: true,
					},
					scales: {
						yAxes: [
							{
								ticks: {
									beginAtZero: true,
								},
							},
						],
					}
				}
			});

			var dailySavingsChart = document.getElementById('dailySavingsChart').getContext('2d');
			var myDailySavingsChart = new Chart(dailySavingsChart, {
				type: 'line',
				data: {
					labels: [
						'00:00', '01:00', '02:00', '03:00', '04:00', 
						'05:00', '06:00', '07:00', '08:00', '09:00', 
						'10:00', '11:00', '12:00', '13:00', '14:00', 
						'15:00', '16:00', '17:00', '18:00', '19:00', 
						'20:00', '21:00', '22:00', '23:00'
					],
					datasets: [{
						label: "{{ $jenisOut->title }}", 
						fill: !0, 
						backgroundColor: "rgba(255,255,255,0.2)", 
						borderColor: "#fff", 
						borderCapStyle: "butt", 
						borderDash: [], 
						borderDashOffset: 0, 
						pointBorderColor: "#fff", 
						pointBackgroundColor: "#fff", 
						pointBorderWidth: 1, 
						pointHoverRadius: 5, 
						pointHoverBackgroundColor: "#fff", 
						pointHoverBorderColor: "#fff", 
						pointHoverBorderWidth: 1, 
						pointRadius: 1, 
						pointHitRadius: 5,
						data: [
							@for($i = 0; $i < 24; $i++)
								@php
									// Mengambil jumlah untuk jam tertentu
									$jumlah = 0;
									foreach ($expenseOfDay as $item) {
										// Mengambil jam dari tanggal
										if (date('H', strtotime($item->jam)) == $i) {
											$jumlah += $item->jumlah; // Menambahkan jumlah jika jam cocok
										}
									}
								@endphp
								{{ $jumlah }},
							@endfor
						]
					}]
				},
				options : {
					maintainAspectRatio:!1, legend: {
						display: !1
					}
					, animation: {
						easing: "easeInOutBack"
					}
					, scales: {
						yAxes:[ {
							display:!1, ticks: {
								fontColor: "rgba(0,0,0,0.5)", fontStyle: "bold", beginAtZero: !0, maxTicksLimit: 10, padding: 0
							}
							, gridLines: {
								drawTicks: !1, display: !1
							}
						}
						], xAxes:[ {
							display:!1, gridLines: {
								zeroLineColor: "transparent"
							},
							ticks: {
								padding: -20, 
								fontColor: "rgba(255,255,255,0.2)", 
								fontStyle: "bold"
							}
						}]
					}
				}
			});
		});
	</script>
</body>
</html>