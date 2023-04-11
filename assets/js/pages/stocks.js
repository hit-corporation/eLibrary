'use strict';
var formUpdate = document.forms['form-update'],
    formSearch = document.forms['form-search'];

const getBooks = async () => {

    try
    {
        const f = await fetch(`${BASE_URL}book/get_all`);
        const j = await f.json();

        return j;
    }
    catch(err)
    {

    }
}

(async $ => {

    const table = $('#table-main').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: BASE_URL + 'stock/get_all_paginated'
        },
        columns: [
            {
                data: 'id',
                visible: false
            },
            {
                data: 'stock_code'
            },
            {
                data: 'book_id',
                visible: false
            },
            {
                data: 'title'
            },
            {
                data: 'rack_no'
            },
            {
                data: 'is_available',
                render(data, type, row, _meta) {
                    switch(data)
                    {
                        case 1:
                            return '<span class="badge badge-success">Tersedia</span>';
                        case 0:
                            return '<span class="badge badge-danger">Tidak Tersedia</span>';
                    }
                }
            },
           
            {
                data: null,
                render(data, type, row, _meta) {
                    var btn = '<span class="d-flex flex-nowrap">' +
                                '<button role="button" class="btn-circle btn-success rounded-circle border-0 edit_data"><i class="fas fa-edit"></i></button>' + 
                                `<a role="button" class="btn-circle btn-danger rounded-circle border-0 delete_data"><i class="fas fa-trash"></i></a>` + 
                              '</span>';
                    return btn;
                }
            }
        ]
    });

     // Select Book form update
     var books = [...await getBooks()];

     var $_books = $(formUpdate['stock_book']).selectize({
         create: false,
         valueField: 'id',
         labelField: 'title',
         options: books,
         searchField: ['title']
     });

     var $book = $_books[0].selectize;

     if(formUpdate['stock_book'].getAttribute('value'))
            $book.setValue(formUpdate['stock_book'].getAttribute('value'));
    // Modal update
    $('#table-main tbody').on('click', '.edit_data', e => {
        var row = table.row(e.target.parentNode.closest('tr')).data();
       
        formUpdate['stock_id'].value = row.id;
        formUpdate['stock_code'].value = row.stock_code;
        formUpdate['stock_book'].value = row.book_id;

        $book.setValue(row.book_id);

        $('#modal-update').modal('show');
    });

    formUpdate.addEventListener('submit', e => {
        loading();
    });

   
    // DELETE DATA
    $('#table-main tbody').on('click', '.delete_data', e => {
       
       
        Swal.fire({
            icon: 'warning',
            title: '<h4 class="text-warning">Apakah anda yakin !?</h4>',
            html: '<h5 class="text-warning">Data yang di hapus tidak dapat di kembalikan.</h5>',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        })
        .then(t => {
          
            if(!t.value) 
                return;

            var row = table.row(e.target.parentNode.closest('tr')).data();
            loading();
            window.location.href = BASE_URL + 'stock/delete/' + row.id;
        });
    });

    // SEARCHING DATA
    formSearch.addEventListener('submit', e => {
        e.preventDefault();

        if(formSearch['s_stock_code'].value)
            table.columns(1).search(formSearch['s_stock_code'].value).draw();
        if(formSearch['s_book'].value)
            table.columns(3).search(formSearch['s_book'].value).draw();
        if(formSearch['s_is_available'].value)
            table.columns(5).search(formSearch['s_is_available'].value).draw();
    });

    formSearch.addEventListener('reset', e => {

        if(!formSearch['s_stock_code'].getAttribute('value'))
            table.columns(1).search('').draw();
        if(!formSearch['s_book'].getAttribute('value'))
            table.columns(3).search('').draw();
        if(!formSearch['s_is_available'].getAttribute('value'))
            table.columns(5).search('').draw();
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