const topTenMemberBorrow = (data) => {

	Highcharts.chart('top-ten-member', {
		chart: {
			type: 'column',
		},
		colors: ['#50a5f1', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
		title: {
			text: '<h6>Top 10 Siswa Meminjam Buku selama 1 bulan terakhir</h6>'
		},
		xAxis: {
			type: 'category',
			labels: {
			rotation: -45,
			style: {
				fontSize: '11px',
				fontFamily: 'Verdana, sans-serif'
			}
			}
		},
		yAxis: {
			min: 0,
			title: {
			text: 'Banyaknya (buku)'
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			pointFormat: 'Total: <b>{point.y:.f} Buku</b>'
		},
		series: [{
			name: 'Population',
			// data: [
			// ['Tokyo', 37.33],
			// ['Delhi', 31.18],
			// ['Shanghai', 27.79],
			// ['Sao Paulo', 22.23],
			// ['Mexico City', 21.91],
			// ['Dhaka', 21.74],
			// ['Cairo', 21.32],
			// ['Beijing', 20.89],
			// ['Mumbai', 20.67],
			// ['Osaka', 19.11]
			// ],
			data: data,
			dataLabels: {
			enabled: true,
			rotation: 0,
			color: '#FFFFFF',
			align: 'right',
			format: '{point.y:.f}', // one decimal
			y: 25, // 10 pixels down from the top
			style: {
				fontSize: '13px',
				fontFamily: 'Verdana, sans-serif'
			}
			}
		}]
	});
}



