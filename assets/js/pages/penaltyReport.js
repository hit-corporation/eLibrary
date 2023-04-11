'use strict'

const formSearch = document.forms['form-search'];

// get all data
const getAll = async () => {
	try{
		const f = await fetch(BASE_URL + '/report/get_all_penalty');
		const j = await f.json();

		return j;
	}catch(err){
		console.log(err);
	}
}

// INIT

(async ($) => {
	const allData = await getAll();

	// Datatable
	const tableMain = $('#table-main').DataTable({
		serverSide: true,
		processing: true,
		ajax: {
			url: BASE_URL + '/report/get_all_penalty_paginated'
		},
		pegeLength: 10,
		columns: [
			{
				data: 'id',
				visible: false
			},
			{
				data: 'member_name',
				className: 'align-middle pl-2'
			},
			{
				data: 'title',
				className: 'align-middle'		
			},
			{
				data: 'trans_timestamp',
				render(data, type, row, _meta){
					const date = new Date(data);
					const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });

					return dateStr;
				}
			},
			{
				data: 'jumlah_hari_pinjam',
				className: 'align-middle',
				render(data, type, row, _meta) {
					return data.replace('days', 'hari')
							   .replace('day', 'hari')
							   .replace('mon', 'bulan')
							   .replace('mons', 'bulan');
				}
			},
			{
				data: 'return_date',
				render(data, type, row, _meta){
					const date = new Date(data);
					const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });

					return dateStr;
				}
			},
			{
				data: 'jumlah_hari_terlambat',
				render(data, type, row, _meta){
					// arrray split
					const arr = data.split(' ');
					const day = arr[0];
					if(day <= 0) return '0 hari';
					return day + ' hari';
				}
			},
			{
				data: 'denda',
				render(data, type, row, _meta){
					// to thousands separator
					if(data == null) return 'Rp. 0';
					const denda = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
					return 'Rp. ' + denda;
				}

			}
		]
	});
	
	// Search submit
	formSearch.addEventListener('submit', e => {
		e.preventDefault();

		// Get daterange value
		let daterange 		= formSearch['daterange'].value;
		let daterangeArr 	= daterange.split(' - ');
		let daterangeStart 	= daterangeArr[0];
		let daterangeEnd 	= daterangeArr[1];
		
		// Create a date object from a date string
		let start 	= new Date(daterangeStart);
		let end 	= new Date(daterangeEnd);

		// Get year, month, day part from the date
		let startYear 	= start.toLocaleString('default', { year: "numeric"});
		let startMonth 	= start.toLocaleString("default", { month: "2-digit" });
		let startDay 	= start.toLocaleString("default", { day: "2-digit" });

		let endYear 	= end.toLocaleString("default", { year: "numeric" });
		let endMonth 	= end.toLocaleString("default", { month: "2-digit" });
		let endDay 		= end.toLocaleString("default", { day: "2-digit" });

		// Generate yyyy-mm-dd date string
		start 	= startYear + '-' + startMonth + '-' + startDay;
		end 	= endYear + '-' + endMonth + '-' + endDay;

		// search by daterange
		tableMain.columns(1).search(formSearch['s_member_name'].value).draw();
		tableMain.columns(2).search(start + ' - ' + end).draw();
		tableMain.columns(3).search(formSearch['s_book_name'].value).draw();
	});

	// Search daterangepicker
	$('input[name="daterange"]').daterangepicker({
		opens: 'right',
		// update naquib
		startDate: moment().subtract(1, 'month'),
		endDate: new Date(),
		locale: {
			format: 'YYYY-MM-DD'
		}
		// end update naquib
	}, function(start, end, label) {
		tableMain.columns(1).search(formSearch['s_member_name'].value).draw();
		tableMain.columns(2).search(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD')).draw();
		tableMain.columns(3).search(formSearch['s_book_name'].value).draw();
	});

	// Download
	document.getElementById('btn-download-excel').addEventListener('click', async e => {
		await downloadFile('excel');
	});

	document.getElementById('btn-download-pdf').addEventListener('click', async e => {
		await downloadFile('pdf');
	});
	
})(jQuery);

// default daterangepicker
$('input[name="daterange"]').val(moment().startOf('month').format('L') + ' - ' + moment().endOf('month').format('L'));

const downloadFile = async ext  => {
	
	const formData = new FormData(formSearch);
	const formObj = Object.fromEntries(formData.entries());
	try
	{
		const config = Object.assign({type: ext}, formObj);
		const uriParam = new URLSearchParams(config).toString();
		const url = new URL(BASE_URL + 'report/download_penalty?' + uriParam);
		// ajax
		window.location.href = url.href;
	}
	catch(err)
	{
		console.log(err);
	}
}
