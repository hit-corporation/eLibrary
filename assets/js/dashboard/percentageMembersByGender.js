// Data retrieved from https://netmarketshare.com
const chartMemberByGender = (percentage_book_borrow) => {
	Highcharts.chart('pie-gender', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		colors: ['#34c38f', '#f46a6a', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e', '#f48024', '#69d2e7'],
		title: {
			text: '<span id="percentageSiswaTitle">Persentase Jenis Kelamin Anggota</span>',
			align: 'left'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
			valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			dataLabels: {
				enabled: true,
				format: '<b>{point.name}</b>: {point.percentage:.1f} %'
			}
			}
		},
		series: [{
			name: 'Siswa',
			colorByPoint: true,
			data: [
				{
				name: 'Laki - laki',
				y: parseFloat(percentage_book_borrow['male']),
				}, {
				name: 'Perempuan',
				y: parseFloat(percentage_book_borrow['female'])
				}
			]
		}]
	});
}

const setPieGenderChart = async () => {

	try {
		
		const f = await fetch(BASE_URL + 'admin/dashboard/get_member_by_gender');
		const j = await f.json();

		chartMemberByGender(j);
	} catch (error) {
		
	}
}
