'use strict';

const formSearchName = document.forms['form-search-name'];

// get all book pa
const getAll = async () => {
	try {
		const f = await fetch(BASE_URL + 'admin/report/get_all_book');
		const j = await f.json();

		return j;
	} catch(err){
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
			url: BASE_URL + 'admin/report/get_all_book_paginated'
		},
		pageLength: 10,
		columns: [
			{
				data: 'id',
				visible: false
			},
			{
				data: 'cover_img',
				className: 'dt-nowrap align-middle',
				width: '8%',
				render: (data, type, row, _meta) => {
					if(data)
						return '<img src="'+BASE_URL+'assets/img/books/'+data+'" height="'+(165 - 50)+'" width="'+(128 - 50)+'">';
					return  '<img src="'+BASE_URL+'assets/img/Placeholder_book.svg" height="'+(165 - 50)+'" width="'+(128 - 50)+'">';;
				}

			},
			{
				data: 'title',
				className: 'align-middle pl-2'
			},
			{
				data: 'qty',
				className: 'align-middle pl-2'
			},
			{
				data: 'qty_dipinjam',
				className: 'align-middle pl-2'
			},
			{
				data: 'author',
				className: 'align-middle pl-2'
			},
			{
				data: 'publisher_name',
				className: 'align-middle pl-2'
			},
			{
				data: 'isbn',
				className: 'align-middle pl-2'
			},
			{
				data: 'publish_year',
				className: 'align-middle pl-2'
			},
			{
				data: 'category_name',
				className: 'align-middle pl-2'
			},
			{
				data: 'created_at',
				className: 'align-middle pl-2'
			},
			{
				data: 'rack_no',
				className: 'align-middle pl-2'
			}

		]
	});

	// Search submit
    formSearchName.addEventListener('submit', e => {
        e.preventDefault();
		tableMain.columns(1).search(formSearchName['s_book_name'].value).draw();
		tableMain.columns(2).search(formSearchName['s_author_name'].value).draw();
		tableMain.columns(3).search(formSearchName['s_publisher_name'].value).draw();
		tableMain.columns(4).search(formSearchName['stok'].value).draw();
		tableMain.columns(5).search(formSearchName['s_rack_number'].value).draw();
    });

	// search reset
	formSearchName.addEventListener('reset', e => {
		e.preventDefault();
		tableMain.columns(1).search('').draw();
		formSearchName['s_book_name'].value = '';

		tableMain.columns(2).search('').draw();
		formSearchName['s_author_name'].value = '';

		tableMain.columns(3).search('').draw();
		formSearchName['s_publisher_name'].value = '';

		tableMain.columns(5).search('').draw();
		formSearchName['s_rack_number'].value = '';
	});

	// Download Report
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
		const url = new URL(BASE_URL + 'admin/report/download_book?' + uriParam);
		// ajax
		window.location.href = url.href;
	}
	catch(err)
	{

	}
}