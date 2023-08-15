<div class="hero user-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
					<h1><?=$user['member_name']?></h1>
					<ul class="breadcumb">
						<li class="active"><a href="<?=base_url()?>">Home</a></li>
						<li> <span class="ion-ios-arrow-right"></span>Profile</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-change-avatar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form action="<?=base_url('user/change_avatar')?>" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ubah Gambar Profile</h5>
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button> -->
				</div>
				<div class="modal-body">
					<!-- create form input change image profile -->

					<!--file input example -->
					<span class="control-fileupload">
						<input type="hidden" name="id" value="<?=$user['id']?>">
						<label for="avatar">Choose a file :</label>
						<input type="file" class="form-control-file" name="avatar" id="avatar">
					</span>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="change_avatar">Save changes</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="page-single">
	<div class="page-single userfav_list">
		<div class="container">
			<div class="row ipad-width2">
				<div class="col-md-3 col-sm-12 col-xs-12">
					<?=$this->load->view('home/users/user-sidebar', ['active' => 'user_review_history'], TRUE)?>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="topbar-filter user">
						<p>Found <span class="total-found"> books</span> in total</p>
						<label>Sort by:</label>
						<select name="sort-by">
							<option value="create-at-asc">Created Asc</option>
							<option value="create-at-desc">Created Desc</option>
							<option value="rating-asc">Rating Asc</option>
							<option value="rating-desc">Rating Desc</option>
						</select>
						<!-- <a href="#" class="list"><i class="ion-ios-list-outline active"></i></a> -->
					</div>

					<div class="flex-wrap-movielist"></div>
	
					<div class="topbar-filter">
						<label>Books per page:</label>
					
						<select name="book-per-pages">
							<option value="5" <?=(isset($limit) && $limit == 5) ? 'selected' : '' ?> >5 Books</option>
							<option value="10" <?=(isset($limit) && $limit == 10) ? 'selected' : '' ?> >10 Books</option>
							<option value="20" <?=(isset($limit) && $limit == 20) ? 'selected' : '' ?>>20 Books</option>
							<option value="50" <?=(isset($limit) && $limit == 50) ? 'selected' : '' ?>>50 Books</option>
							<option value="100" <?=(isset($limit) && $limit == 100) ? 'selected' : '' ?>>100 Books</option>
						</select>
					
						<div class="pagination2">
							<!-- <span>Page 1 of 2:</span>
							<a class="active" href="#">1</a>
							<a href="#">2</a>
							<a href="#">3</a>
							<a href="#">...</a>
							<a href="#">78</a>
							<a href="#">79</a>
							<a href="#"><i class="ion-arrow-right-b"></i></a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-give-rate" tabindex="-1" aria-labelledby="giveRateModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		
		<div class="modal-content">
			<!-- <div class="modal-header"> -->
				<h5 class="modal-title" id="giveRateModalLabel">Beri Ulasan & Rating Buku</h5>
			<!-- </div> -->
			<div class="modal-body-give-rate">
				
			</div>
			<!-- <div class="modal-footer"> -->
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal(this)">Close</button>
				<button type="submit" class="btn btn-primary" name="simpan-ulasan">Save changes</button>
			<!-- </div> -->
		</div>
		
	</div>
</div>

<script>
	// create swall alert
	<?php if(!empty($_SESSION['success'])) : ?>
		Swal.fire({
            icon: 'success',
            title: '<h4 class="text-success"></h4>',
            html: '<span class="text-success"><?= $_SESSION['success']['message'] ?></span>',
            timer: 5000
        });

	<?php endif; ?>

	<?php if(!empty($_SESSION['error'])) : ?>
		Swal.fire({
			icon: 'error',
			title: '<h4 class="text-danger"></h4>',
			html: '<span class="text-danger">Data Gagal di ubah!</span>',
			timer: 5000
		});
	<?php endif; ?>

	// change avatar
	$('#change-avatar').on('click', function(e){
		e.preventDefault();
		// show modal
		$('#modal-change-avatar').modal('show');

	});

	// input file change show modal
	$('input[type=file]').change(function(){
		$('#modal-change-avatar').modal('show');

		var t = $(this).val();
		var labelText = 'File : ' + t.substr(12, t.length);
		$(this).prev('label').text(labelText);
	});

	

	$(document).ready(function () {
		var view_style 	= 'list';
		var sort_by 	= $('select[name="sort-by"]').val();
		var limit 		= $('select[name="book-per-pages"]').val();

		load_data(1, limit, sort_by);

		const empty_data = () => {
			$('.flex-wrap-movielist').empty();
			$('.pagination2').empty();
		}

		var coverImage = null;
		var linkImage = null;
		const check_image = (img) => {
			// check img is null
			if (img == null) {
				coverImage = 'default.png';
				linkImage = '<?=base_url('assets/img/books/default.png')?>';
			}else{
				
				// check file exist
				$.ajax({
					url: '<?=base_url('assets/img/books/')?>' + img,
					type:'HEAD',
					error: function()
					{
						coverImage = 'default.png';
						linkImage = '<?=base_url('assets/img/books/default.png')?>';
					},
					success: function()
					{
						coverImage = img;
						linkImage = '<?=base_url('assets/img/books/')?>' + img;
					},
					async: false
				});
			}
			
		}

		// select sort-by di ubah
		$('select[name="sort-by"]').on('change', function (e) {
			e.preventDefault();

			empty_data();

			sort_by = $(this).val();
			load_data(1, limit, sort_by);
		});

		// create function load data
		function load_data(page, limit = '', sort_by = ''){
			$.ajax({
				type: "POST",
				url: "<?=base_url('user/get_user_review_history')?>",
				data: {
					sort_by: sort_by,
					page: page,
					limit: limit,
				},
				dataType: 'JSON',
				success: function (response) {
					// console.log(response);
					
					var defaultImg = "<?=base_url('assets/img/books/default.png')?>";

					// jika view style list
					$.each(response.books, function (key, value){
						check_image(value.cover_img);

						$('.flex-wrap-movielist').append(`
							<div class="movie-item-style-2">

								<img src="${linkImage}" alt="" style="width:100px">
			
								<div class="mv-item-infor">
									<h6><a href="<?=base_url('/home/book_detail?id=')?>${value.book_id}">${value.title} <span>(${value.publish_year})</span></a></h6>

									<div class="no-star" style="font-size: 20px;">
										${star(value.rating)}
									</div>
									<p class="time"> ${formatDateTime(value.created_at,1)} </p>
									<p class="describe mt-1">${value.notes}</p>
								</div>
							</div>
						`);
					});

					for(let i = 0; i < response.total_pages; i++){
						$('.pagination2').append(`<a class="halaman" id="halaman_${i+1}" href="#">${i+1}</a>`);

						$(`#halaman_${i+1}`).on('click', e => {
							e.preventDefault();

							empty_data();
							load_data(i+1, limit, sort_by);	
						});
					}

					// append total-found
					$('.total-found').empty();
					$('.total-found').append(response.total_found);

				}
			});
		}

		// select book-per-pages di ubah
		$('select[name="book-per-pages"]').on('change', function (e) {
			e.preventDefault();

			empty_data();

			limit = $(this).val();
			load_data(1, limit, sort_by);
		});

		
	});
	
	// BUTTON ULAS DI KLIK
	function ulas(e){
		let image = e.parentElement.parentElement.children[0].attributes.src.value;
		let title = e.parentElement.children[0].children[0].innerText;
		let bookId = e.attributes.data.value;
		// console.log(title); return;

		$('.modal-body-give-rate').html('');

		$('#modal-give-rate').modal('show');
		$('#modal-give-rate').css('margin-top', '100px');
		$('#modal-give-rate').modal({backdrop: 'static', keyboard: true});

		$('.modal-body-give-rate').append(`
			<table class="table-auto" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<img class="mt-3 mb-3" src="${image}" width="150px">
					</td>

					<td>
						<p>${title}</p>

						<div id="rating">
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
						</div>

						<textarea placeholder="Yuk, ceritain kepuasanmu tentang kualitas buku ini." class="mt-1"></textarea>
						
					</td>
				</tr>
			</table>
		`);

	}

	// CREATE STAR RATING ICON
	function star(rating){
		let ratingStar = '';
		for(let i = 1; i <= 5; i++){
			if(i <= rating){
				ratingStar += `<i class="ion-android-star"></i>`;
			}else{
				ratingStar += `<i class="ion-android-star last"></i>`;
			}
		}

		return ratingStar
	}

	// PAGE NUMBER DI KLIK
	function pageNumberClick(e){
		let viewPerPage = $('.view-per-page').val();
		rating_by_book_id(e.text, viewPerPage, 'create-at-desc', bookId);
	}

	// VIEW PER PAGE DI UBAH
	$('.view-per-page').on('change', function(e){
		let viewPerPage = e.currentTarget.value;
		let orderByRating = $('#order-by-rating').val();
		rating_by_book_id(1, viewPerPage, orderByRating, bookId);
	});

	// ORDER BY RATING
	$('#order-by-rating').on('change', function(e){
		let orderBy = e.currentTarget.value;
		let viewPerPage = $('.view-per-page').val();

		rating_by_book_id(1, viewPerPage, orderBy, bookId);
	});
	
	// CREATE DATE FORMAT
	function formatDateTime(sDate,FormatType) {
		var lDate = new Date(sDate)

		var month=new Array(12);
		month[0]="Januari";
		month[1]="Februari";
		month[2]="Maret";
		month[3]="April";
		month[4]="Mey";
		month[5]="Juni";
		month[6]="Juli";
		month[7]="Agustus";
		month[8]="September";
		month[9]="Oktober";
		month[10]="November";
		month[11]="Desember";

		var weekday=new Array(7);
		weekday[0]="Minggu";
		weekday[1]="Senin";
		weekday[2]="Selasa";
		weekday[3]="Rabu";
		weekday[4]="Kamis";
		weekday[5]="Jumat";
		weekday[6]="Sabtu";

		var hh = lDate.getHours() < 10 ? '0' + 
			lDate.getHours() : lDate.getHours();
		var mi = lDate.getMinutes() < 10 ? '0' + 
			lDate.getMinutes() : lDate.getMinutes();
		var ss = lDate.getSeconds() < 10 ? '0' + 
			lDate.getSeconds() : lDate.getSeconds();

		var d = lDate.getDate();
		var dd = d < 10 ? '0' + d : d;
		var yyyy = lDate.getFullYear();
		var mon = eval(lDate.getMonth()+1);
		var mm = (mon<10?'0'+mon:mon);
		var monthName=month[lDate.getMonth()];
		var weekdayName=weekday[lDate.getDay()];

		if(FormatType==1) {
		return dd+' '+monthName+' '+yyyy+' '+hh+':'+mi;
		} else if(FormatType==2) {
		return weekdayName+', '+monthName+' '+ 
				dd +', ' + yyyy;
		} else if(FormatType==3) {
		return mm+'/'+dd+'/'+yyyy; 
		} else if(FormatType==4) {
		var dd1 = lDate.getDate();    
		return dd1+'-'+Left(monthName,3)+'-'+yyyy;    
		} else if(FormatType==5) {
			return mm+'/'+dd+'/'+yyyy+' '+hh+':'+mi+':'+ss;
		} else if(FormatType == 6) {
			return mon + '/' + d + '/' + yyyy + ' ' + 
				hh + ':' + mi + ':' + ss;
		} else if(FormatType == 7) {
			return  dd + '-' + monthName.substring(0,3) + 
				'-' + yyyy + ' ' + hh + ':' + mi + ':' + ss;
		}
	}

</script>
