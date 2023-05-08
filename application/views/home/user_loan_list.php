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

</script>
