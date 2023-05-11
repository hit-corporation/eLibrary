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

	

	<!-- Begin Page Content -->
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center mb-4">
			<div class="btn-group" role="group" aria-label="Basic example">
				<a href="admin/dashboard" class="btn btn-secondary">Dashboard 1</a>
				<a href="admin/dashboard/dashboard2" class="btn bg-info text-light">Dashboard 2</a>
			</div>
		</div>

		<!-- Content Row Card -->

		<!-- Content Row Line Charts -->
		<div class="row">

			<div class="col-6 mb-3 mt-2">
				<div class="container border rounded-lg shadow mx-0">
					<figure class="highcharts-figure">
						<div id="avg-person"></div>
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
	<!-- highchart  -->
	<script src="<?=base_url('assets/js/dashboard/highcharts/highcharts.js')?>"></script>
	<script src="<?=base_url('assets/js/dashboard/highcharts/accessibility.js')?>"></script>

	<!-- BAR CHART  -->
	<script>
		// get avg per person
		const getAveragePerson = async () => {
			try {
				
				const f = await fetch(BASE_URL + 'admin/dashboard/get_average_read_member');
				const j = await f.json();

				return j.data;

			} catch (error) {
				
			}
		}

		(async () => {

			const series1 = [...await getAveragePerson()].map(x => {
				var hours = x.avg_duration.split(':');
				var duration = parseFloat(hours[0] + '.' + hours[1]);
				var data = {
					'name': x.member_name, 
					'data': duration
				}
				return data;
			});
			console.log(series1);

			Highcharts.chart('avg-person', {
				chart: {
					type: 'column'
				},
				colors: ['#34c38f', '#f46a6a', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
				title: {
					text: 'Rata - Rata Durasi Membaca Per Siswa'
				},
				subtitle: {
					// text: 'Source: WorldClimate.com'
				},
				xAxis: {
					categories: series1.map(x => x.name),
					max: 4,
					crosshair: true
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Rata - rata waktu baca (Jam)'
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f} Siswa</b></td></tr>',
					//footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
				series: series1
			});


		})();
	
	</script>

<?php $this->stop() ?>
