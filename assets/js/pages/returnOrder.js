'use strict';

const form = document.forms['form-input'];
var finesAmount = 0;

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

// get all members
const getMembers = async () => {

    try
    {
        const f = await fetch(`${BASE_URL}/member/get_all?is_borrowing=true`);
        const j = await f.json();
        
        return j;
    }
    catch(err)
    {
        console.log(err);
    }
}

// show result setting
setting().then(res => {
	finesAmount = res.fines_amount;
});

(async $ => {
	const members = [...await getMembers()];

	// member select
    var selectMember = $('select[name="member"]').selectize({
        valueField: 'card_number',
        labelField: 'member_name',
        searchField: ['member_name'],
        options: members,
		onItemSelect: e => {
            console.log(e);
        },
        onChange: value => {
            
			$.ajax({
				url: '/member/get_by_card_number/' + value,
				type: 'GET',
				success: function(res) {
					let data = JSON.parse(res);
	
					if(data == null) {
						// hide member info
						$('#member-info').hide();
	
						// show member group
						$('#member-group').show();
	
						// clear input scan kartu
						$('#card_no').val('');
	
						Swal.fire({
							title: 'Error!',
							text: 'Member not found!',
							icon: 'error',
							confirmButtonText: 'Ok'
						});
						return;
					}
					
					// $('#member-group').hide();
					$('#member-info').show();
					$('#member-id').val(data.id);
					$('#member-name').text(data.member_name);
					$('#member-nis').text(data.no_induk);
					$('#member-kelas').text(data.kelas);
		
					// show book orders
					$('#book-orders').show();
		
					// ajax call to get book orders
					$.ajax({
						url: '/order/get_by_member_id/' + data.id,
						type: 'GET',
						success: function(res2) {
		
							let data2 = JSON.parse(res2);
		
							// delete book orders
							$('#book-orders-body').empty();
							$('#fines').val(0);
		
							$.each(data2, function (index, value) { 
								// convert date to local
								let transTimestamp = new Date(value.trans_timestamp).toLocaleDateString();
								let returnDate = new Date(value.return_date).toLocaleDateString();

								let denda = 0;
								if(value.denda)
									denda = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value.denda);

								// append book orders
								$('#book-orders-body').append(`
									<tr>
										<td>
											${value.book_code}
											<input type="hidden" name="book_id[${index}]">
											<input type="hidden" name="id[${index}]">
											<input type="hidden" name="trans_code[${index}]">
											<input type="hidden" name="book_code[${index}]">
											<input type="hidden" name="late_days[${index}]">
										</td>
										<td>${value.title}</td>
										<td>${transTimestamp}</td>
										<td>${returnDate}</td>
										<td>${denda}<input type="hidden" name="denda[${index}]"></td>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="defaultCheck${index}" name="book_check[${index}]" value="${value.id}">
											</div>
										</td>
									</tr>
								`);
		
								// calculate fines
								$(`#defaultCheck${index}`).on('change', function() {
									if(this.checked) {
										// Do something...
										console.log('checked');
		
										// calculate fines
										let fines = parseInt($('#fines').val()) + parseInt(value.denda) ?? 0;
										
										// append 
										$('#fines').val(!isNaN(fines) ? fines : 0);
										$(`input[name="id[${index}]"]`).val(value.id);
										$(`input[name="book_id[${index}]"]`).val(value.book_id);
										$(`input[name="denda[${index}]"]`).val(value.denda);
										$(`input[name="book_code[${index}]"]`).val(value.book_code);
										$(`input[name="trans_code[${index}]"]`).val(value.trans_code);
										$(`input[name="late_days[${index}]"]`).val(value.jumlah_hari_terlambat);
		
		
									}else{
										// Do something...
										console.log('unchecked');
		
										// calculate fines
										let fines = (parseInt($('#fines').val()) - parseInt(value.denda)) ?? 0;
		
										// append 
										$('#fines').val(!isNaN(fines) ? fines : 0);
										$(`input[name="id[${index}]"]`).val('');
										$(`input[name="book_id[${index}]"]`).val('');
										$(`input[name="denda[${index}]"]`).val('');
										$(`input[name="book_code[${index}]"]`).val('');
										$(`input[name="trans_code[${index}]"]`).val('');
										$(`input[name="late_days[${index}]"]`).val('');
									}
								});
								 
							});
							
						}
		
					});
		
				},
				error: function() {
					console.log('data tidak ditemukan');
	
					// clear member info
					$('#member-info').hide();
				}
			});

        }
	});

	var selectize = selectMember[0].selectize;

	// ajax call to get member info
	$('#card_no').keypress(function() {

		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13') {

			var cardNumber = $(this).val();
			$.ajax({
				url: '/member/get_by_card_number/' + cardNumber,
				type: 'GET',
				success: function(res) {
					let data = JSON.parse(res);

					if(data == null) {
						// hide member info
						$('#member-info').hide();

						// show member group
						$('#member-group').show();

						// clear input scan kartu
						$('#card_no').val('');

						Swal.fire({
							title: 'Error!',
							text: 'Member not found!',
							icon: 'error',
							confirmButtonText: 'Ok'
						});
						return;
					}

					selectize.setValue(data.card_number);
					
					// $('#member-group').hide();
					$('#member-info').show();
					$('#member-id').val(data.id);
					$('#member-name').text(data.member_name);
					$('#member-nis').text(data.no_induk);
					$('#member-kelas').text(data.kelas);
		
					// show book orders
					$('#book-orders').show();
		
					// ajax call to get book orders
					$.ajax({
						url: '/order/get_by_member_id/' + data.id,
						type: 'GET',
						success: function(res2) {
		
							let data2 = JSON.parse(res2);
		
							// delete book orders
							$('#book-orders-body').empty();
							$('#fines').val(0);
		
							$.each(data2, function (index, value) { 
								// convert date to local
								let transTimestamp = new Date(value.trans_timestamp).toLocaleDateString();
								let returnDate = new Date(value.return_date).toLocaleDateString();
		
								// append book orders
								$('#book-orders-body').append(`
									<tr>
										<td>
											${value.book_code}
											<input type="hidden" name="book_id[${index}]">
											<input type="hidden" name="id[${index}]">
											<input type="hidden" name="trans_code[${index}]">
											<input type="hidden" name="book_code[${index}]">
											<input type="hidden" name="late_days[${index}]">
										</td>
										<td>${value.title}</td>
										<td>${transTimestamp}</td>
										<td>${returnDate}</td>
										<td>${value.denda ?? 0}<input type="hidden" name="denda[${index}]"></td>
										<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="defaultCheck${index}" name="book_check[${index}]" value="${value.id}">
											</div>
										</td>
									</tr>
								`);
		
								// calculate fines
								$(`#defaultCheck${index}`).on('change', function() {
									if(this.checked) {
										// Do something...
										console.log('checked');
		
										// calculate fines
										let fines = parseInt($('#fines').val()) + parseInt(value.denda) ?? 0;
										console.log(fines);
										// append 
										$('#fines').val(!isNaN(fines) ? fines : 0);
										$(`input[name="id[${index}]"]`).val(value.id);
										$(`input[name="book_id[${index}]"]`).val(value.book_id);
										$(`input[name="denda[${index}]"]`).val(value.denda);
										$(`input[name="book_code[${index}]"]`).val(value.book_code);
										$(`input[name="trans_code[${index}]"]`).val(value.trans_code);
										$(`input[name="late_days[${index}]"]`).val(value.jumlah_hari_terlambat);
		
		
									}else{
										// Do something...
										console.log('unchecked');
		
										// calculate fines
										let fines = (parseInt($('#fines').val()) - parseInt(value.denda)) ?? 0;
		
										// append 
										$('#fines').val(!isNaN(fines) ? fines : 0);
										$(`input[name="id[${index}]"]`).val('');
										$(`input[name="book_id[${index}]"]`).val('');
										$(`input[name="denda[${index}]"]`).val('');
										$(`input[name="book_code[${index}]"]`).val('');
										$(`input[name="trans_code[${index}]"]`).val('');
										$(`input[name="late_days[${index}]"]`).val('');
									}
								});
								
							});
							
						}
		
					});
		
				},
				error: function() {
					console.log('data tidak ditemukan');

					// clear member info
					$('#member-info').hide();
				}
			});

		}

	});


})(jQuery);



// hide member info
$('#member-info').hide();



// show alert jika jumlah bayar lebih besar dari denda
$('#return-order-form').on('submit', function(e) {
	e.preventDefault();

	let fines = parseInt($('#fines').val());
	let jumlahBayar = parseInt($('#jumlah_bayar').val());
	if(jumlahBayar > fines) {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Jumlah bayar tidak boleh melebihi dari total denda!',
		});
	}else{
		this.submit();
	}
});


// select2 for member
$(document).ready(function() {
	// hide select-member-name
	$('.select-member-name-group').hide();

	$('.select-member-name').select2();

	$('.select-member-name').on('change', function() {
		$.ajax({
			type: "post",
			url: "/member/get_by_member_name",
			data: {
				member_name: $(this).val()
			},
			dataType: "json",
			success: function (response) {
				console.log(response);
			}
		});
	});
});
