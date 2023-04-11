'use strict';

const form = document.forms['form-input'],
      formSearch = document.forms['form-search'];

// get all data
const getAll = async () => {
    try
    {
        const f = await fetch(BASE_URL + '/kategori/get_all');
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
            url: BASE_URL + '/kategori/get_all_paginated'
        },
        pageLength: 7,
        columns: [
            {
                data: 'id',
                visible: false
            },
            {
                data: 'category_name',
                className: 'align-middle pl-2'
            },
            {
                data: 'parent_category',
                visible: false
            },
            {
                data: 'parent_category',
                className: 'align-middle',
                render(data, type, row, _meta)
                {
                    let parent = '';

                    if(allData.find(x => x.id == data))
                        parent = allData.find(x => x.id == data).category_name;
                    return parent;
                }
            },
            {
                data: null,
                render(data, type, row, _meta)
                {
                    const btn = '<span class="d-flex flex-nowrap">' +
                                '<button role="button" class="btn-circle btn-success rounded-circle border-0 edit_data"><i class="fas fa-edit"></i></button>' + 
                                '<button role="button" class="btn-circle btn-danger rounded-circle border-0 delete_data"><i class="fas fa-trash"></i></button>' + 
                                '</span>';

                    return btn;
                }
            }
       ]
    });
    
    // tree
    const treedata = allData.map(x => ({id: x.id, text: x.category_name, parent: x.parent_category == null ? '#' : x.parent_category }));

    $('#tree-container').jstree({
        core: {
            multiple: false,
            data: treedata
        },
        checkbox: {
            'three_state': false,
            'tie_selection': true
        },
        plugins: ['checkbox']
    })
    .bind('select_node.jstree', (e, data) => {
        document.querySelector('input[name="category_parent"]').value = data.node.id;
    })
    .bind('deselect_node.jstree', (e, data) => {
        document.querySelector('input[name="category_parent"]').value = '';
    })
    .bind('loaded.jstree', (e, data) => {
        if(document.querySelector('input[name="category_parent"]').value)
            $('#tree-container').jstree(true).select_node(form['category_parent'].value);
    });

    // store
    document.getElementById('btn-add').addEventListener('click', e => {
        form.reset();
        form.action = BASE_URL + 'kategori/store';

        $('#tree-container').jstree(true).deselect_all();
    });

    // update
    $('#table-main').on('click', 'button.edit_data', e => {
        let row = tableMain.row($(e.target).parents('tr')[0]).data();
        
        form.reset();
        form['category_id'].value = row.id;
        form['category_name'].value = row.category_name;
        form['category_parent'].value = row.parent_category;
        $('#tree-container').jstree(true).deselect_all();
        $('#tree-container').jstree(true).select_node(form['category_parent'].value);

        form.action = BASE_URL + 'kategori/edit';

        $('#modal-input').modal('show');
    });

    // delete
    $('#table-main').on('click', 'button.delete_data', e => {

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

            let row = tableMain.row($(e.target).parents('tr')[0]).data();
            loading();
            window.location.href = BASE_URL + 'kategori/erase/' + row.id;
        });
    });

    // form reset
    form.addEventListener('reset', e => {
        $('#tree-container').jstree(true).deselect_all();
    });

    // form submit
    form.addEventListener('submit', e => {
        loading();
    });

    // search-tree
    $('#search-tree div:first-child').jstree({
        core: {
            multiple: false,
            data: treedata
        },
        checkbox: {
            'three_state': false,
            'tie_selection': true
        },
        plugins: ['checkbox']
    })
    .bind('select_node.jstree', (e, data) => {
        formSearch['s_category_parent'].value = data.node.id;
        formSearch['s_category_parent_text'].value = data.node.text;
    })
    .bind('deselect_node.jstree', (e, data) => {
        formSearch['s_category_parent'].value = '';
        formSearch['s_category_parent_text'].value = '';
    });

    // dropdown click (sbiar ga langsung close abis klik)
    $('#search-tree').on('click', e => {
        e.stopPropagation();
    });

    // Search submit
    formSearch.addEventListener('submit', e => {
        e.preventDefault();

        if(formSearch['s_category_name'].value)
            tableMain.columns(1).search(formSearch['s_category_name'].value).draw();
        if(formSearch['s_category_parent'].value)
            tableMain.columns(2).search(formSearch['s_category_parent'].value).draw();
        
    });

    // reset submit
    formSearch.addEventListener('reset', e => {
        $('#search-tree div:first-child').jstree(true).deselect_all();
        tableMain.columns(1).search('').draw();
        tableMain.columns(2).search('').draw();
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