const top_book_borrow = (data, title) => {
	var options = {
		series: [{
			// data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
			data: data,
		}],
		chart: {
			type: 'bar',
			height: 430
		},
		plotOptions: {
			bar: {
				barHeight: '100%',
				distributed: true,
				horizontal: true,
				dataLabels: {
					position: 'bottom'
				},
			}
		},
		colors: ['#f46a6a', '#f1b44c', '#34c38f', '#e83e8c', '#556ee6', '#80DCFF', '#A4E6FF', '#ADDAEA', '#94B6C2', '#94B6C2'],
		dataLabels: {
			enabled: true,
			textAnchor: 'start',
			style: {
				colors: ['#fff']
			},
			formatter: function (val, opt) {
				return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
			},
			offsetX: 0,
			dropShadow: {
				enabled: true
			}
		},
		stroke: {
			width: 1,
			colors: ['#fff']
		},
		xaxis: {
			// categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'India'],
			categories: title,
		},
		yaxis: {
			labels: {
				show: false
			}
		},
		title: {
			text: 'TOP 5 BUKU TERBANYAK DIPINJAM',
			align: 'center',
			floating: true
		},
		// subtitle: {
		// 	text: 'Nama buku terdapat di dalam grafik',
		// 	align: 'center',
		// },
		tooltip: {
			theme: 'dark',
			x: {
				show: false
			},
			y: {
				title: {
					formatter: function () {
						return '';
					}
				}
			}
		}
	};
	
	var chart = new ApexCharts(document.querySelector("#chartdiv2"), options);
	chart.render();
}

