

<div class="hero common-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
					<h1><?//=$title?></h1>
					<ul class="breadcumb">
						<li class="active"><a href="<?=base_url()?>">Home</a></li>
						<li> <span class="ion-ios-arrow-right"></span> Book listing</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single">
	<div class="container">
		<div class="row ipad-width">
			<div class="col-md-8 col-sm-12 col-xs-12">
				<div class="topbar-filter">
					<p>Found <span><?//=$total?> Books</span> in total</p>
					<label>Sort by:</label>
					<select name="sortBy">
						<option value="title-asc">Title Descending</option>
						<option value="title-desc">Title Ascending</option>
					</select>
					<a href="movielist.html" class="list"><i class="ion-ios-list-outline "></i></a>
					<a  href="moviegrid.html" class="grid"><i class="ion-grid active"></i></a>
				</div>
				<div class="flex-wrap-movielist">

					<!-- <?php foreach ($books as $book): ?>

						<div class="movie-item-style-2 movie-item-style-1">
							<img src="<? // =base_url('assets/img/books/').$book['cover_img']?>" alt="">
							<div class="hvr-inner">
	            				<a  href="<? // =base_url('/home/book_detail?id=').$book['id']?>"> Read more <i class="ion-android-arrow-dropright"></i> </a>
	            			</div>
							<div class="mv-item-infor">
								<h6><a href="<? // =base_url('/home/book_detail?id=').$book['id']?>"><? // =$book['title']?></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p>
							</div>
						</div>

					<?php endforeach; ?> -->

						
				</div>		
				<div class="topbar-filter">
					<label>Books per page:</label>
					<select name="book-per-pages">
						<option value="10" <?=(isset($limit) && $limit == 10) ? 'selected' : '' ?> >10 Books</option>
						<option value="20" <?=(isset($limit) && $limit == 20) ? 'selected' : '' ?>>20 Books</option>
						<option value="50" <?=(isset($limit) && $limit == 50) ? 'selected' : '' ?>>50 Books</option>
						<option value="100" <?=(isset($limit) && $limit == 100) ? 'selected' : '' ?>>100 Books</option>
					</select>

					<!-- create pagination codeigniter -->


					
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
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="sidebar">
					<div class="searh-form">
						<h4 class="sb-title">Cari Buku</h4>
						<form class="form-style-1" action="#">
							<div class="row">
								<div class="col-md-12 form-it">
									<label>Nama Buku</label>
									<input type="text" placeholder="Masukan Nama Buku" name="title">
								</div>

								<div class="col-md-12 form-it">
									<label>Pengarang</label>
									<input type="text" placeholder="Masukan Nama Pengarang" name="author">
								</div>

								<div class="col-md-12 form-it">
									<label>Kategori</label>
									<div class="group-ip">
										<select
											name="skills" multiple="" class="ui fluid dropdown">
											<option value="">Enter to filter genres</option>
											<option value="Action1">Action 1</option>
					                        <option value="Action2">Action 2</option>
					                        <option value="Action3">Action 3</option>
					                        <option value="Action4">Action 4</option>
					                        <option value="Action5">Action 5</option>
										</select>
									</div>	
								</div>
								<div class="col-md-12 form-it">
									<label>Penerbit</label>
									<select name="publisher">
										<option value="">Pilih Penerbit</option>
										<?php foreach ($publishers as $publisher): ?>
											<option value="<?=$publisher['id']?>"><?=$publisher['publisher_name']?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-12 form-it">
									<label>Tahun Terbit</label>
									<div class="row">
										<div class="col-md-6">
											<select>
											  <option value="range">From</option>
											  <option value="number">10</option>
											</select>
										</div>
										<div class="col-md-6">
											<select>
											  <option value="range">To</option>
											  <option value="number">20</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12 ">
									<input class="submit" type="submit" value="submit" name="submit">
								</div>
							</div>
						</form>
					</div>
				
				</div>
			</div>
		</div>
	</div>
</div>
<!-- import cdn jquery -->

<script>
	$(document).ready(function () {

		// data awal di load
		var title = $('input[name="title"]').val();
		var limit = $('select[name="book-per-pages"]').val();
		var publisher_id = $('select[name="publisher"]').val();
		var author = $('input[name="author"]').val();

		load_data(1, limit, title, publisher_id, author);

		function load_data(page, limit = null, title = '', publisher_id = '', author = '') {
			$.ajax({
				type: "GET",
				url: "<?=base_url('book/get_all')?>",
				data: {
					page: page,
					limit: limit,
					title: title,
					publisher_id: publisher_id,
					author: author
				},
				success: function (data) {
					// console.log(data.total_page);
					
					$.each(data.books, function (key, value) {
						$('.flex-wrap-movielist').append(`
							<div class="movie-item-style-2 movie-item-style-1">
								<img loading="lazy" src="<?=base_url('assets/img/books/')?>${value.cover_img}" onload="this.style.opacity = 1;" alt="">
							<div class="hvr-inner">
	            				<a  href="<?=base_url('/home/book_detail?id=')?>${value.id}"> Read more <i class="ion-android-arrow-dropright"></i> </a>
	            			</div>
							<div class="mv-item-infor">
								<h6><a href="<?=base_url('/home/book_detail?id=')?>${value.id}">${value.title}</a></h6>
								<!-- <p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p> -->
							</div>`);
					});

					for(let i = 0; i < data.total_pages; i++){
						$('.pagination2').append(`<a class="halaman" id="halaman_${i+1}" href="#">${i+1}</a>`);

						$(`#halaman_${i+1}`).on('click', e => {
							e.preventDefault();

							$('.flex-wrap-movielist').empty();
							$('.pagination2').empty();
							load_data(i+1, limit, title, publisher_id, author);	
						});
					}

				}
			});
		}

		// select book-per-pages di ubah
		$('select[name="book-per-pages"]').on('change', function (e) {
			e.preventDefault();

			$('.flex-wrap-movielist').empty();
			$('.pagination2').empty();

			limit = $(this).val();
			load_data(1, limit, title, publisher_id, author);
		});

		// submit di klik
		$('input[name="submit"]').on('click', function (e) {
			e.preventDefault();

			$('.flex-wrap-movielist').empty();
			$('.pagination2').empty();

			title = $('input[name="title"]').val();
			publisher_id = $('select[name="publisher"]').val();
			author = $('input[name="author"]').val();

			load_data(1, limit, title, publisher_id, author);
		});

	});
</script>
