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
					<?=$this->load->view('home/users/user-sidebar', ['active' => 'user_loan'], TRUE)?>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="topbar-filter user">
						<p>Found <span class="total-found"> books</span> in total</p>
						<label>Sort by:</label>
						<select name="sort-by">
							<option value="title-asc">Title Ascending</option>
							<option value="title-desc">Title Descending</option>
						</select>
						<a href="#" class="list"><i class="ion-ios-list-outline active"></i></a>
						<a href="#" class="grid"><i class="ion-grid "></i></a>
					</div>

					<div class="flex-wrap-movielist"></div>

					<div class="flex-wrap-movielist-2 user-fav-list">

						<!-- <?php // foreach($favorite_books as $key => $val):?>
						<div class="movie-item-style-2">
							<img src="<? // =base_url('assets/img/books/').$val['cover_img']?>" alt="">
							<div class="mv-item-infor">
								<h6><a href="#"><? // =$val['title']?> <span>(<? // =$val['publish_year']?>)</span></a></h6>
								<p class="describe"><? // =substr($val['description'], 0, 300)?>...</p>

								<a class="btn btn-xs btn-primary" href="<? // =base_url('User/delete_favorite_book?id=').$val['id']?>">Delete Favorite</a>
								
								<p>Penulis: <a href="#"><? // =$val['author']?></a></p>
								<p>ISBN: <a href="#"><? // =$val['isbn']?></a></p>
								<p>Penerbit: <a href="#"><? // =$val['publisher_name']?></a></p>
								<p>Kategori: <a href="#"><? // =$val['category_name']?></a></p>
							</div>
						</div>
						<?php // endforeach;?> -->

					</div>		
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
			$('.flex-wrap-movielist-2').empty();
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
				type: "GET",
				url: "<?=base_url('user/get_user_loan')?>",
				data: {
					sort_by: sort_by,
					page: page,
					limit: limit,
				},
				success: function (response) {
					console.log(response);
					
					var defaultImg = "<?=base_url('assets/img/books/default.png')?>";

					// jika view style list
					if(view_style == 'list'){
						$.each(response.books, function (key, value){
							let desc = value.description;
							if(desc.length > 100){
								desc = desc.substring(0, 300) + ' ...';
							}

							check_image(value.cover_img);

							$('.flex-wrap-movielist-2').append(`
								<div class="movie-item-style-2">

									<img src="${linkImage}" alt="">
				
									<div class="mv-item-infor">
										<h6><a href="<?=base_url('/home/book_detail?id=')?>${value.id}">${value.title} <span>(${value.publish_year})</span></a></h6>
										<a class="btn btn-xs btn-primary" href="<?=base_url('book/return_book?id=')?>${value.id}">Kembalikan Buku</a>
										<span class="btn btn-xs btn-success" onclick="ulas(this)" data="${value.id}">Ulas</span>
										<p class="describe">${desc}</p>
										<p class="run-time">Pengarang: ${value.author}.</p>
										<p>Kategori: <a href="#">${value.category_name}</a></p>
										<p>Penerbit: <a href="#">${value.publisher_name}</a></p>
									</div>
								</div>
							`);
						});
					}else{
						$.each(response.books, function (key, value) {

							check_image(value.cover_img);

							$('.flex-wrap-movielist').append(`
								<div class="movie-item-style-2 movie-item-style-1">

									<img loading="lazy" src="${linkImage}" onload="this.style.opacity = 1;" alt="">
									
								<div class="hvr-inner">
									<a  href="<?=base_url('/home/book_detail?id=')?>${value.id}"> Read more <i class="ion-android-arrow-dropright"></i> </a>
								</div>
								<div class="mv-item-infor">
									<h6><a href="<?=base_url('/home/book_detail?id=')?>${value.id}">${value.title}</a></h6>
									<a class="btn btn-xs btn-primary" href="<?=base_url('book/return_book?id=')?>${value.id}">Kembalikan Buku</a>
									<span class="btn btn-xs btn-success mt-1 d-inline-block" onclick="ulas(this)" data="${value.id}">Ulas</span>
									<!-- <p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p> -->
								</div>`);
						});
					}

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

		// tampilan list di klik
		$('.list').on('click', function (e) {
			e.preventDefault();

			empty_data();

			view_style = 'list';
			load_data(1, limit, sort_by);
		});

		// tampilan grid di klik
		$('.grid').on('click', function (e) {
			e.preventDefault();

			empty_data();

			view_style = 'grid';
			load_data(1, limit, sort_by);
		});

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

		// KETIKA RATING STAR DI KLIK
		document.querySelector('#rating').addEventListener('click', function (e) {
			let action = 'add';
			for (const span of this.children) {
				span.classList[action]('active');
				if (span === e.target) action = 'remove';
			}
		});

		// TOMBOL SIMPAN ULASAN DI KLIK
		document.getElementsByName('simpan-ulasan')[0].addEventListener('click', function(){
			// HITUNG JUMLAH BINTANG
			let rating = document.querySelector('#rating');
			var counterRate = 0;
			for(const rate of rating.children){
				if(rate.className == 'active') counterRate++;
			}

			let notes = document.querySelector('.modal-body-give-rate textarea').value;

			// JALANKAN AJAX POST KE book/save_rating
			$.ajax({
				type: "POST",
				url: BASE_URL + "book/save_rating",
				data: {
					bookId: bookId,
					rating: counterRate,
					notes: notes
				},
				dataType: "JSON",
				success: function (response) {
					if(response.success == true){
						
					}
				}
			});
		});

	}

	// CLOSE MODAL GIVE RATING
	function closeModal(e){
		$('#modal-give-rate').modal('hide');
	}

</script>
