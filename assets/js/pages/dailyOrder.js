'use strict';

$('#status').val('belum').trigger('change');

const form = document.forms['form-input'];
const formSearch = document.forms['form-search'];

// get all data
const getAll = async () => {
    try
    {
        const f = await fetch(BASE_URL + '/order/get_all');
        const j = await f.json();

        return j;
    }   
    catch(err)
    {
        console.log(err);
    }    
}

// SETTING
const setting = async () => {
	try
	{
		const f = await fetch(BASE_URL + '/setting/get_all');
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
            url: BASE_URL + '/order/get_all_paginated'
        },
        pageLength: 10,
        columns: [
            {
                data: 'id',
                visible: false
            },
            {
                data: 'book_id',
                visible: false
            },
            {
                data: 'member_name',
                className: 'align-middle pl-2'
            },
			{
                data: 'title',
            },
            {
                data: 'trans_timestamp',
				render(data, type, row, _meta)
				{
					const date = new Date(data);
					const dateStr = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });

					return dateStr;
				}
            },
			{
				// JUMLAH HARI PINJAM
				data: 'jumlah_hari_pinjam',
				render(data, type, row, _meta)
				{
					const date1 = new Date(row.trans_timestamp);
					const date2 = new Date(row.return_date);
					const diffTime = Math.abs(date2 - date1);
					const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

					return diffDays + ' hari';
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
				data: 'jumlah_hari_terlambat',
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
				//DENDA
				data: 'denda',
				render(data, type, row, _meta) {
					return new Intl.NumberFormat('id', { style: 'currency', currency: 'IDR'}).format(data);
				}
			},
			{
				// paid amount
				data: 'amount_paid',
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
						// show text belum dikembalikan posisi tengah
						return '<span class="badge badge-danger p-2">Belum dikembalikan</span>';
					}
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
		tableMain.columns(1).search(formSearch['s_member_name'].value).draw();
		tableMain.columns(2).search(start + ' - ' + end).draw();
		tableMain.columns(3).search(formSearch['status'].value).draw();
		tableMain.columns(4).search(formSearch['s_book_name'].value).draw();
        
    });

	// Update data
	$('#table-main').on('click', '.update_data', function() {
	
		const data = tableMain.row($(this).parents('tr')).data();
		const id = data.id;
		const book_id = data.book_id;
		const member_name = data.member_name;
		const book_title = data.title;
		const stock_code = data.stock_code;
		const trans_code = data.trans_code;
		const return_date = data.return_date;

		let lateDays = data.jumlah_hari_terlambat;
		if(data.jumlah_hari_terlambat)
		{
			lateDays = lateDays.replace('days', 'hari')
							   .replace('day', 'hari')
							   .replace('mons', 'bulan')
							   .replace('mon', 'bulan')
							   .replace('years', 'tahun')
							   .replace('year', 'tahun');
		}

		let diffDays = data.jumlah_hari_pinjam.replace('days', 'hari')
												.replace('day', 'hari')
												.replace('mons', 'bulan')
												.replace('mon', 'bulan')
												.replace('years', 'tahun')
												.replace('year', 'tahun');
		let jumlah_hari_terlambat = lateDays;
		let denda = data.denda;
		
		
		// show modal
		$('#modal-update').modal('show');

		// set value
		$('#modal-update input[name="transaction_book_id"]').val(id);
		$('#modal-update input[name="trans_code"]').val(trans_code);
		$('#modal-update input[name="book_id"]').val(book_id);
		$('#modal-update input[name="member_name"]').val(member_name);
		$('#modal-update input[name="book_title"]').val(book_title);
		$('#modal-update input[name="stock_code"]').val(stock_code);
		$('#modal-update input[name="jumlah_hari_terlambat"]').val(jumlah_hari_terlambat);
		$('#modal-update input[name="denda"]').val(denda);
		$('#modal-update input[name="bayar"]').val(denda);

	
	});

	// Search daterangepicker auto submit
	// ketika daterangepicker di klik maka akan otomatis melakukan pencarian
	$('input[name="daterange"]').daterangepicker({
		opens: 'left',
	}, function(start, end, label) {
		tableMain.columns(1).search(formSearch['s_member_name'].value).draw();
		tableMain.columns(2).search(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD')).draw();
		tableMain.columns(3).search(formSearch['status'].value).draw();
		tableMain.columns(4).search(formSearch['s_book_name'].value).draw();
	});

	// search reset
	formSearch.addEventListener('reset', e => {
		e.preventDefault();
		tableMain.columns(1).search('').draw();
		formSearch['s_member_name'].value = '';

		tableMain.columns(2).search('').draw();
		formSearch['daterange'].value = '';

		tableMain.columns(3).search('').draw();
		formSearch['status'].value = '';

		tableMain.columns(4).search('').draw();
		formSearch['s_book_name'].value = '';

	});

})(jQuery);

const loading = () => {
    Swal.fire({
        html: 	'<div class="d-flex flex-column align-items-center">'
        + '<span class="spinner-border text-primary"></span>'
        + '<h3 class="mt-2">Loading...</h3>'
        + '<div>',
        showConfirmButton: false,
        width: '10rem'
    });
}

// default daterangepicker
$('input[name="daterange"]').val(moment().startOf('month').format('L') + ' - ' + moment().endOf('month').format('L'));
