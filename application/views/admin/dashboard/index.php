<?php $this->layout('layouts::admin_template', ['title' => 'Dashboard'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>
	<!-- highchart  -->
	<script src="<?=base_url('assets/js/dashboard/highcharts/highcharts.js')?>"></script>
	<script src="<?=base_url('assets/js/dashboard/highcharts/accessibility.js')?>"></script>

	<!-- apex charts -->
	<script src="./assets/js/dashboard/apexcharts/apexcharts.js"></script>
	<style>
		.highcharts-credits {
			display: none;
		}
		.highcharts-figure,
		.highcharts-data-table table {
		min-width: 320px;
		max-width: 800px;
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

	<!-- Begin Page Content -->

	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center mb-4">
			<div class="btn-group" role="group" aria-label="Basic example">
				<a href="dashboard" class="btn bg-info text-light">Dashboard 1</a>
				<a href="dashboard/dashboard2" class="btn btn-secondary">Dashboard 2</a>
			</div>
		</div>

		<!-- Content Row -->
		<div class="row">

			<!-- Total Member (All) -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									Total Member</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_member?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-users fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Buku (All) -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Total Buku</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_book?></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-book fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Buku Dipinjam (All) -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Buku Dipinjam
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$total_borrow_book?></div>
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
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
									Telat Pengembalian</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comments fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>

		<!-- Content Row -->
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2">
				<div class="container border rounded-lg shadow p-3">

					<figure class="highcharts-figure" style="height: 417px;">
						<div id="container"></div>
					</figure>
				</div>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="container border rounded-lg shadow p-3">
					<div id="chartdiv2" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
		</div>

		<!-- Content Row -->
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2 mt-3">
				<div class="container border rounded-lg shadow mx-0">
					<figure class="highcharts-figure">
						<div id="top-ten-member"></div>
					</figure>
				</div>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-2 mt-3">
				<div class="container border rounded-lg shadow mx-0">
					<figure class="highcharts-figure">
						<div id="monyhly-member-borrow"></div>
					</figure>
				</div>
			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

<?php $this->stop() ?>

<!-- SECTION JS -->
<?php $this->start('js') ?>

	<script src="./assets/js/dashboard/percentageBookBorrow.js"></script>
	<script src="./assets/js/dashboard/topBookBorrow.js"></script>
	<script src="./assets/js/dashboard/topTenMemberBorrow.js"></script>

	<script>
		// percentage_book_borrow(<?= json_encode($percentage_book_borrow) ?>);
		// top_book_borrow(<?= json_encode(array_column($top_book_borrow , 'total')) ?>, <?= json_encode(array_column($top_book_borrow , 'title')) ?>);
		
		// // create data for chart top ten member borrow
		// var dataTopMember = [];
		// <?php foreach($top_member_borrow as $key => $value) : ?>
		// 	dataTopMember.push({
		// 		name: '<?= $value['member_name'] ?>',
		// 		y: <?= $value['total'] ?>
		// 	});
		// <?php endforeach; ?>

		// topTenMemberBorrow(dataTopMember);

		// // set temout for change font
		setTimeout(() => {
			// change font
			let SvgjsText1005 = document.querySelector('#SvgjsText1005');
			SvgjsText1005.style.fontSize = '12px';
			SvgjsText1005.style.fontFamily = '"Poppins",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"'

		}, 500);
	</script>
















	<script>
		// get category
		var category = [];
		let monthNames = ["Jan", "Feb", "Mar", "Apr", "Mey", "Jun", "Jul", "Agu", "Sep", "Okt", "Nop", "Des"];

		<?php foreach($daily_borrow as $key => $value) : ?>


			var date = new Date('<?= $value['date'] ?>');
			var month = date.getMonth() + 1;
			var day = date.getDate();
			var year = date.getFullYear();

			category.push(day + ' ' + monthNames[date.getMonth()]);

		<?php endforeach; ?>

		// get data
		var data = [];
		<?php foreach($daily_borrow as $key => $value) : ?>
			data.push(<?= $value['total'] ?>);
		<?php endforeach; ?>


		// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
		Highcharts.chart('monyhly-member-borrow', {
			chart: {
				type: 'line'
			},
			title: {
				text: 'Peminjaman Buku Harian'
			},
			xAxis: {
				// categories: ['1 feb', '2 feb', '3 feb', '4 feb', '5 feb', '6 feb', '7 feb', '8 feb', '9 feb', '10 feb', '11 feb', '12 feb', '13 feb', '14 feb', '15 feb', '16 feb', '17 feb', '18 feb', '19 feb', '20 feb', '21 feb', '22 feb', '23 feb', '24 feb', '25 feb', '26 feb', '27 feb', '28 feb', '1 mar', '2 mar']
				categories: category
			},
			yAxis: {
				title: {
					text: 'Total Peminjaman / Hari'
				}
			},
			plotOptions: {
				line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
				}
			},
			series: [{
				name: 'Siswa',
				// data: [16, 18, 23, 27, 32, 36, 39, 38, 35, 29, 22, 17, 16, 18, 23, 27, 32, 36, 39, 38, 35, 29, 22, 17, 16, 18, 23, 27, 32, 36]
				data: data
			},
		]
		});

	</script>




<?php $this->stop() ?>
