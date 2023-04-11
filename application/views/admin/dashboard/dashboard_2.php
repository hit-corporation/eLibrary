<?php $this->layout('layouts::admin_template', ['title' => 'Dashboard2'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>
	
	<style>
		.highcharts-credits {
			display: none;
		}
		.highcharts-figure,
		.highcharts-data-table table {
			min-width: 320px;
			max-width: 100%;
			margin: 1em auto;
		}

		.highcharts-data-table table {
			font-family: Verdana, sans-serif;
			border-collapse: collapse;
			border: 1px solid #ebebeb;
			margin: 10px auto;
			text-align: center;
			width: 100%;
			max-width: 500px;
		}

		.highcharts-data-table caption {
			padding: 1em 0;
			font-size: 1.2em;
			color: #555;
		}

		.highcharts-data-table th {
			font-weight: 600;
			padding: 0.5em;
		}

		.highcharts-data-table td,
		.highcharts-data-table th,
		.highcharts-data-table caption {
			padding: 0.5em;
		}

		.highcharts-data-table thead tr,
		.highcharts-data-table tr:nth-child(even) {
			background: #f8f8f8;
		}

		.highcharts-data-table tr:hover {
			background: #f1f7ff;
		}

		input[type="number"] {
			min-width: 50px;
		}

		#top-ten-member {
			height: 400px;
		}

	</style>
<?php $this->stop() ?>

<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

	<!-- highchart  -->
	<script src="<?=base_url('assets/js/dashboard/highcharts/highcharts.js')?>"></script>
	<script src="<?=base_url('assets/js/dashboard/highcharts/accessibility.js')?>"></script>

	<!-- Begin Page Content -->
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center mb-4">
			<div class="btn-group" role="group" aria-label="Basic example">
				<a href="dashboard" class="btn btn-secondary">Dashboard 1</a>
				<a href="dashboard/dashboard2" class="btn bg-info text-light">Dashboard 2</a>
			</div>
		</div>

		<!-- Content Row Card -->
		<div class="row">

			<!-- Total Member (All) -->
			<div class="col-xl-3 col-md-6 mb-2">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									Total Pembayaran Denda Bulan Ini</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?=(isset($fines_this_month)) ? number_format($fines_this_month) : 0 ;?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-usd fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Buku (All) -->
			<div class="col-xl-3 col-md-6 mb-2">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Total Pembayaran Denda Bulan Lalu</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?=(isset($fines_last_month)) ? number_format($fines_last_month) : 0 ;?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-book fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Buku Dipinjam (All) -->
			<div class="col-xl-3 col-md-6 mb-2">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Denda Berjalan
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp <?=(isset($running_fine)) ? number_format(array_sum(array_column($running_fine, 'denda'))) : 0 ;?></div>
									</div>
								</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Telat (All) -->
			<div class="col-xl-3 col-md-6 mb-2">
				<div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
									Telat Pengembalian</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?=isset($late_return) ? $late_return : 0; ?> Buku</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comments fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<!-- Content Row Line Charts -->
		<div class="row">

			<div class="col-6 mb-3 mt-2">
				<div class="container border rounded-lg shadow mx-0">
					<figure class="highcharts-figure">
						<div id="book-borrow"></div>
					</figure>
				</div>
			</div>

			<div class="col-6 mb-3 mt-2">
				<div class="container border rounded-lg shadow mx-0">
					<figure class="highcharts-figure">
						<div id="book-borrow-barchart"></div>
					</figure>
				</div>
			</div>
		
		</div>

	</div>

<?php $this->stop() ?>


<!-- SECTION JS -->
<?php $this->start('js') ?>

	<!-- CHART PEMINJAMAN BUKU HARIAN -->
	<script async>
		// create day of month
		var dayOfMonth = [];

		for (let i = 1; i <= 31; i++) {
			dayOfMonth.push(i);
		}

		// set value to 0
		var data = [];
		for (let i = 1; i <= 31; i++) {
			data.push(0);
		}

		let totalThisMonth = 0,
			totalLastMonth = 0;

		// loop data and set value
		var dailyBorrow = <?= json_encode($daily_borrow) ?>;
		dailyBorrow.forEach(function (value, index) {
			// parse date
			var date = new Date(value.date);
			var day = date.getDate();

			totalThisMonth += value.total;
			// set value
			data[day - 1] = value.total;
		});
		
		// set value to 0
		var data2 = [];
		for (let i = 1; i <= 31; i++) {
			data2.push(0);
		}
		
		// loop data and set value
		var dailyBorrowLastMonth = <?= json_encode($daily_borrow_last_month) ?>;
		dailyBorrowLastMonth.forEach(function (value, index) {
			// parse date
			var date = new Date(value.date);
			var day = date.getDate();

			totalLastMonth += value.total;

			// set value
			data2[day - 1] = value.total;
		});

		// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
		Highcharts.chart('book-borrow', {
			chart: {
				type: 'line'
			},
			title: {
				text: 'Peminjaman Buku Harian'
			},
			xAxis: {
				categories: dayOfMonth
			},
			yAxis: {
				title: {
					text: 'Total Peminjaman / Hari'
				}
			},
			plotOptions: {
				line: {
				dataLabels: {
					enabled: false
				},
				enableMouseTracking: false
				}
			},
			series: [{
				name: 'April',
				data: data
			},{
				name: 'Maret',
				data: data2
			}
		]
		});

	</script>

	<!-- BAR CHART  -->
	<script>
		Highcharts.chart('book-borrow-barchart', {
			chart: {
				type: 'column'
			},
			colors: ['#34c38f', '#f46a6a'],
			title: {
				text: 'Summary Peminjaman Buku Bulanan'
			},
			subtitle: {
				// text: 'Source: WorldClimate.com'
			},
			xAxis: {
				categories: [
				'Siswa'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
				text: 'Total Siswa'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.0f} Siswa</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
				pointPadding: 0.2,
				borderWidth: 0
				}
			},
			series: [{
				name: 'Bulan Lalu',
				data: [totalLastMonth]

			}, {
				name: 'Bulan Ini',
				data: [totalThisMonth]

			}]
		});
	</script>

<?php $this->stop() ?>
