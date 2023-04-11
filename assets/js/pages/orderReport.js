'use strict'

const formSearchName = document.forms['form-search-name'];

// get all data
const getAll = async () => {
	try
	{
		const f = await fetch(BASE_URL + '/report/get_all');
		const j = await f.json();

		return j;
	}
	catch(err)
	{
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
			url: BASE_URL + '/report/get_all_paginated'
		},
		pageLength: 10,
		columns: [
			{
                data: 'id',
                visible: false
            },
            {
                data: 'trans_code',
                className: 'align-middle pl-2'
            },
            {
                data: 'member_name',
                className: 'align-middle pl-2'
            },
			{
                data: 'book_title',
            },
            {
                data: 'loan_date',
				render(data, type, row, _meta)
				{
					const date = new Date(data);
					const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });

					return dateStr;
				}
            },
			{
				// JUMLAH HARI PINJAM
				data: 'loan_days',
				render(data, type, row, _meta)
				{
					return data.replace('days', 'hari')
							   .replace('day', 'hari')
							   .replace('mon', 'bulan')
							   .replace('mons', 'bulan')
							   .replace('00:00:00', '0');
				}

				
			},
            {
                data: 'return_date',
				render(data, type, row, _meta)
				{
					const date = new Date(data);
					const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });

					return dateStr;
				}
            },
            {
				// JUMLAH HARI TERLAMBAT
				data: 'late_days',
				render(data, type, row, _meta)
				{ 
					var results = null;
					if(data)
					{
						results = data.replace('days', 'hari').replace('day', 'hari');
						results = results.replace('mons', 'bulan').replace('mon', 'bulan');
						results = results.replace('years', 'tahun').replace('year', 'tahun');
					}
					
					return results;
				}

            },
			{
				// DENDA
				data: 'fines_total',
				render(data, type, row, _meta)
				{
					// const date1 = new Date(row.return_date);
					// const date2 = new Date();
					
					// if(date2 > date1 && row.updated_at == null)
					// {
					// 	const diffTime = Math.abs(date2 - date1);
					// 	const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
					// 	const denda = diffDays * 500;

					// 	if(denda > 10000){
					// 		return 'Rp. 10.000';
					// 	} else {
					// 		return 'Rp. ' + denda.toLocaleString('id-ID');
					// 	}

					// } else if (date2 > date1 && row.updated_at != null) {
					// 	const date3 = new Date(row.updated_at);
					// 	const diffTime = Math.abs(date3 - date1);
					// 	const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
					// 	const denda = diffDays * 500;

					// 	if(denda > 10000){
					// 		return 'Rp. 10.000';
					// 	} else {
					// 		return 'Rp. ' + denda.toLocaleString('id-ID');
					// 	}

					// } else {
					// 	return 'Rp. 0';
					// }
					if(data)
						return 'Rp ' + data.toLocaleString('id-ID');
					return 0;


				}
			},
			{
				// paid amount
				data: 'fines_payment',
				render(data, type, row, _meta)
				{
					if (data == null) {
						return 'Rp. 0';
					} else {
						return 'Rp. ' + data.toLocaleString('id-ID');
					}
				}
			},
			{
				// tanggal pengembalian
				data: 'actual_return',
				render(data, type, row, _meta)
				{
					if(data != null)
					{
						const date = new Date(data);
						const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });
						const timeStr = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
						const dateTimeStr = dateStr + ' ' + timeStr;

						return dateTimeStr;
					} else {
						return '-';
					}
				}

			},
			{
				// note
				data: 'notes',
				render(data, type, row, _meta)
				{
					if(data != null || data != '')
					{
						return data;
					} else {
						return '-';
					}
				}
			}
		]
	});

	// Search submit
    formSearchName.addEventListener('submit', e => {
        e.preventDefault();
		
		// Get daterange value
        let daterange 		= formSearchName['daterange'].value;
		let daterangeArr 	= daterange.split(' - ');
		let daterangeStart 	= daterangeArr[0];
		let daterangeEnd	= daterangeArr[1];
		
		// Create a date object from a date string
		let start 	= new Date(daterangeStart);
		let end 	= new Date(daterangeEnd);

		// Get year, month, and day part from the date
		let startYear 	= start.toLocaleString("default", { year: "numeric" });
		let startMonth 	= start.toLocaleString("default", { month: "2-digit" });
		let startDay 	= start.toLocaleString("default", { day: "2-digit" });

		let endYear 	= end.toLocaleString("default", { year: "numeric" });
		let endMonth 	= end.toLocaleString("default", { month: "2-digit" });
		let endDay 		= end.toLocaleString("default", { day: "2-digit" });

		// Generate yyyy-mm-dd date string
		start 	= startYear + '-' + startMonth + '-' + startDay;
		end 	= endYear + '-' + endMonth + '-' + endDay;

		// search by daterange
		tableMain.columns(1).search(formSearchName['s_member_name'].value).draw();
		tableMain.columns(2).search(start + ' - ' + end).draw();
		tableMain.columns(3).search(formSearchName['status'].value).draw();
		tableMain.columns(4).search(formSearchName['s_book_name'].value).draw();
    });

	// reset
	formSearchName.addEventListener('reset', e => {
		tableMain.columns(1).search('').draw();
		tableMain.columns(2).search('').draw();
		tableMain.columns(3).search('').draw();
		tableMain.columns(4).search('').draw();
	});

	// Search daterangepicker auto submit
	// ketika daterangepicker di klik maka akan otomatis melakukan pencarian
	$('input[name="daterange"]').daterangepicker({
		opens: 'left',
		startDate: moment().subtract(1, 'month'),
		endDate: moment(),
		locale: {
			format: 'YYYY-MM-DD'
		}
	}, function(start, end, label) {
		tableMain.columns(1).search(formSearchName['s_member_name'].value).draw();
		tableMain.columns(2).search(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD')).draw();
		tableMain.columns(3).search(formSearchName['status'].value).draw();
		tableMain.columns(4).search(formSearchName['s_book_name'].value).draw();
	});

	document.getElementById('btn-download-excel').addEventListener('click', async e => {
		await downloadFile('excel');
	});

	document.getElementById('btn-download-pdf').addEventListener('click', async e => {
		await downloadFile('pdf');
	});
	
})(jQuery);


const downloadFile = async ext  => {
	
	const formData = new FormData(formSearchName);
	const formObj = Object.fromEntries(formData.entries());
	try
	{
		const config = Object.assign({type: ext}, formObj);
		const uriParam = new URLSearchParams(config).toString();
		const url = new URL(BASE_URL + 'report/download_trans?' + uriParam);
		// ajax
		window.location.href = url.href;
	}
	catch(err)
	{

	}
}
