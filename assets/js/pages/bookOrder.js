'use strict';
const tableForm = document.getElementById('book-form');
const tbody = tableForm.tBodies[0];
const form = document.forms['form-input'];
let idx = document.querySelectorAll('.book-row').length;

const setReturnDate = (date, duration, unit) => {
    
    let after = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    switch(unit)
    {
        case 'days':
            after.setDate(date.getDate() + (duration + 1));  
            break;
        case 'weeks':
            after.setDate(date.getDate() + 1 + (7 * duration));
            break;
        case 'months':
            after.setMonth(date.getMonth() + duration);
            break;

    }

    return after;
}


// get all books
const getBooks = async () => {

    try 
    {
        const f = await fetch(`${BASE_URL}/book/get_all`);
        const j = await f.json();
        
        return j;
    } 
    catch (error) 
    {
        console.log(error);
    }
}

// get all members
const getMembers = async () => {

    try
    {
        const f = await fetch(`${BASE_URL}/member/get_all`);
        const j = await f.json();
        
        return j;
    }
    catch(err)
    {
        console.log(err);
    }
}

// get all stocks
// const getStocks = async () => {
//     try
//     {
//         const f = await fetch(`${BASE_URL}/stock/get_all`);
//         const j = await f.json();
        
//         return j;
//     }
//     catch(err)
//     {
//         console.log(err);
//     }
// }

// add new book row
const addData = async () => {
    idx = document.querySelectorAll('.book-row').length + 1;

    const tr = tbody.insertRow();
    tr.classList.add('d-flex', 'flex-column','d-lg-table-row', 'book-row');

    const cell_0 = tr.insertCell(0);
    const cell_1 = tr.insertCell(1);
    const cell_2 = tr.insertCell(2);
    const cell_3 = tr.insertCell(3);

    cell_0.innerHTML = '<label class="d-lg-none mb-0">Judul</label>' +
                        `<input type="text" class="d-none" name="book[${idx}][book_id]"/>` + 
                       `<input type="text" class="form-control book-code" name="book[${(idx)}][book_code]" autocomplete="off" autofocus>`;
    cell_0.classList.add('d-inline-block', 'd-lg-table-cell');
    // cell 1
    cell_1.innerHTML = '<label class="d-lg-none mb-0">Judul</label>' +
                       `<select class="form-control book-title" name="book[${(idx)}][title]"></select>`; 
    cell_1.classList.add('d-inline-block', 'd-lg-table-cell');
    
    // cell 2
    cell_2.innerHTML =  '<label class="d-lg-none mb-0">Tgl Pengembalian</label>' + 
                        `<input type="date" class="form-control" name="book[${(idx)}][return_date]"` + 
						'value="'+ form['end-date'].value + '">';
    cell_2.classList.add('d-inline-block', 'd-lg-table-cell');
    // cell 3
    const btnDelete = document.createElement('button');
    btnDelete.innerHTML = '<i class="fas fa-trash"></i>';
    btnDelete.classList.add('btn-circle', 'btn-danger', 'rounded-circle', 'border-0', 'delete_data');
    btnDelete.type = 'button';
    btnDelete.onclick = async e => await deleteRow(e);

    //cell_3.innerHTML =  '<button href="javascript:void(0)" class="btn-circle btn-danger rounded-circle border-0 delete_data"><i class="fas fa-trash"></i></button>';
    cell_3.appendChild(btnDelete);
    cell_3.classList.add('d-inline-block', 'd-lg-table-cell');
    
    // delete button;

}

// delete form-book row
const deleteRow = async e => {
    e.target.parentNode.closest('tr').remove();
}


(async $ => {
	const books = [...await getBooks()];
    const members = [...await getMembers()];

    // default datetime
    document.querySelector('input[name="start-date"]').valueAsDate = new Date();

	// set end date today + 7 days
	document.querySelector('input[name="end-date"]').valueAsDate = setReturnDate(form['start-date'].valueAsDate, SETTINGS['due_date_value'], SETTINGS['due_date_unit']);
    
    // default tanggal kembali 7 hari dari sekarang pada form tambah
    tbody.querySelector('input[name="book[0][return_date]"]').valueAsDate = setReturnDate(form['start-date'].valueAsDate, SETTINGS['due_date_value'], SETTINGS['due_date_unit']);
    

    // member select
    var selectMember = $('select[name="member"]').selectize({
        valueField: 'id',
        labelField: 'member_name',
        searchField: ['member_name'],
        options: members
    });

    var sMember = selectMember[0].selectize;
    sMember.load(e => {
        if(form['member'].getAttribute('value'))
            sMember.setValue(form['member'].getAttribute('value'));
    });

    // book add
    var $select0 = $('select[name="book[0][title]"]').selectize({
        create: true,
        valueField: 'id',
        labelField: 'title',
        searchField: ['title'],
        options: books,
        onItemSelect: e => {
            console.log(e);
        },
        onChange: value => {
            var select = document.querySelector('select[name="book[0][title]"]');
            var tr = select.parentNode.closest('tr');
            if(!tr.nextElementSibling && (tbody.rows.length <= parseInt(SETTINGS['max_allowed'])))
                addData();
        }
    });
    var selectize = $select0[0].selectize;

     // add new row when selectiojn chnge

	selectize.load(e => {
		if(form['book[0][title]'].getAttribute('value'))
			selectize.setValue(form['book[0][title]'].getAttribute('value'));
	});

	var bookTitles = document.querySelectorAll('.book-title');

	if(bookTitles && bookTitles.length > 0)
	{
		Array.from([...bookTitles], (item, idx) => {
		
			var $select = $(item).selectize({
				create: false,
				valueField: 'id',
				labelField: 'title',
				searchField: ['title', 'book_code'],
				options: books,
                onChange: value => {
                    var select = document.querySelector('select[name="book['+ idx +'][title]"]');
                    var tr = select.parentNode.closest('tr');
                    if(!tr.nextElementSibling && (tbody.rows.length <= parseInt(SETTINGS['max_allowed'])))
                        addData();
                }
			});
	
			var sel = $select[0].selectize;
	
			sel.load(e => {
				if(item.getAttribute('value'))
					sel.setValue(item.getAttribute('value'));
			})
	
		});
	}

    var $selects = [];
    
    // Stock Code autocomplete
    window.addEventListener('keypress', e => {
        if(e.code.toLowerCase() === 'enter') {
            e.preventDefault();
            
            const element = e.target;
            const matcher = element.name.match(/book\[([0-9]){1,4}\]\[book_code\]$/);

            if(matcher)
            {  
                if(element.value)
                {
                    const buku = books.find(i => i.book_code === element.value);

                    if(matcher[1] == 0)
                        selectize.setValue(buku.id);
                    else
                        $selects[matcher[1] - 1].setValue(buku.id);
                    
                    // buat cursor
                    var tr = element.parentNode.closest('tr');

                    if(tr.nextElementSibling)
                    {
                        var bookID = (tr.nextElementSibling).getElementsByClassName('book-code')[0];
                        bookID.focus();
                    }
                }
            }
            // if is member card
            if(element.name == 'card_no')
            {
                if(element.value) 
                {
                    const member = members.find(i => i.card_number == element.value);
                    sMember.setValue(member.id);
                }
            }
        }
    });

	
    // check changes on book form table
 

    const mConfig = { childList: true };
    var observer = new MutationObserver(async (mutations, obsrv) => {
        const mut = mutations[0];

        // console.log(mut.addedNodes);
       $(document).ready(function() {
            $selects = [];
            Array.from({length: idx}, (v, n) => {
                var $select = $('select[name="book['+(n + 1)+'][title]"]').selectize({
                   create: false,
                   valueField: 'id',
                   labelField: 'title',
                   searchField: ['title'],
                   options: books,
                   onChange: value => {
                        var select = document.querySelector('select[name="book['+(n + 1)+'][title]"]');
                        select.value = value;
                        var tr = select.parentNode.closest('tr');
                        if(!tr.nextElementSibling && (tbody.rows.length < parseInt(SETTINGS['max_allowed'])))
                            addData();
                   }
                    
                });

                 var sel = $select[0].selectize;
                 $selects.push(sel);

             
            });
       });
       
    });
    
    observer.observe(tbody, mConfig);

    // add new book order forms
    document.getElementById('btn-add-book').addEventListener('click', async e => {
        if(tbody.rows.length >= parseInt(SETTINGS['max_allowed']))
            return;
        await addData();

        //setTimeout(() => observer.disconnect(), 3000);
    });

    
    // input end-date change then all tgl pengembalian must changes
    document.querySelector('input[name="end-date"]').addEventListener('change', e => {
       
        Array.from(tbody.rows, item => {
            
            var inputDate = item.cells[2].getElementsByTagName('input')[0];
            console.log(inputDate);
            inputDate.valueAsDate = e.target.valueAsDate;

        })

    });
  
    form.addEventListener('submit', e => {
        loading();
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
