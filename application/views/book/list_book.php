

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
					<p>Found <span class="total-found"> </span></p>
					<label>Sort by:</label>
					<select name="sort-by">
						<option value="">-- Pilih --</option>
						<option value="title-asc">Title Ascending</option>
						<option value="title-desc">Title Descending</option>
					</select>
					<a href="#" class="list"><i class="ion-ios-list-outline "></i></a>
					<a  href="#" class="grid"><i class="ion-grid active"></i></a>
				</div>
				<div class="flex-wrap-movielist"></div>
				
				<div class="flex-wrap-movielist-2"></div>
				
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
										<select name="category_id" multiple="" class="ui fluid dropdown">
											<option value="">Enter to filter genres</option>
											<?php foreach ($categories as $category): ?>
												<option value="<?=$category['id']?>"><?=$category['category_name']?></option>
											<?php endforeach; ?>
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
											<input type="number" min="1900" max="<?=date('Y', time())?>" value="2000" placeholder="From" name="start_year">
										</div>
										<div class="col-md-6">
											<input type="number" min="1900" max="<?=date('Y', time())?>" value="<?=date('Y', time())?>" placeholder="To" name="end_year">
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
		var view_group 		= '<?=$viewGroup?>';
		var view_style 		= '<?=$viewStyle?>';
		var title 			= $('input[name="title"]').val();
		var limit 			= $('select[name="book-per-pages"]').val();
		var publisher_id 	= $('select[name="publisher"]').val();
		var author 			= $('input[name="author"]').val();
		var category_ids 	= '<?=$category_id?>';
		var year 			= $('input[name="start_year"]').val() + '-' + $('input[name="end_year"]').val();
		var sort_by 		= $('select[name="sort-by"]').val();

		var filter = {
			title: title,
			publisher_id: publisher_id,
			author: author,
			category_ids: category_ids,
			year: year
		}

		load_data(1, limit, filter, sort_by);

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

		function load_data(page, limit = null, filter, sort_by = '') {
			$.ajax({
				type: "GET",
				url: "<?=base_url('book/get_all')?>",
				data: {
					view_group: view_group,
					view_style: view_style,
					page: page,
					limit: limit,
					filter: filter,
					sort_by: sort_by
				},
				success: function (data) {

					var defaultImg = '<?=base_url('assets/img/books/default.png')?>';
					
					// jika view style list
					if(view_style == 'list'){
						$.each(data.books, function (key, value){
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
										<p class="describe">${desc}</p>
										<p class="run-time">Pengarang: ${value.author}.</p>
										<p>Kategori: <a href="#">${value.category_name}</a></p>
										<p>Penerbit: <a href="#">${value.publisher_name}</a></p>
									</div>
								</div>
							`);
						});
					}else{
						$.each(data.books, function (key, value) {

							check_image(value.cover_img);

							$('.flex-wrap-movielist').append(`
								<div class="movie-item-style-2 movie-item-style-1">

									<img loading="lazy" src="${linkImage}" onload="this.style.opacity = 1;" alt="">
									
								<div class="hvr-inner">
									<a  href="<?=base_url('/home/book_detail?id=')?>${value.id}"> Read more <i class="ion-android-arrow-dropright"></i> </a>
								</div>
								<div class="mv-item-infor">
									<h6><a href="<?=base_url('/home/book_detail?id=')?>${value.id}">${value.title}</a></h6>
									<!-- <p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p> -->
								</div>`);
						});
					}


					for(let i = 0; i < data.total_pages; i++){
						$('.pagination2').append(`<a class="halaman" id="halaman_${i+1}" href="#">${i+1}</a>`);

						$(`#halaman_${i+1}`).on('click', e => {
							e.preventDefault();

							empty_data();
							load_data(i+1, limit, filter, sort_by);	
						});
					}

					// append total-found
					$('.total-found').empty();
					$('.total-found').append(`${data.total_records} Buku`);

				}
			});
		}

		// select book-per-pages di ubah
		$('select[name="book-per-pages"]').on('change', function (e) {
			e.preventDefault();

			empty_data();

			limit = $(this).val();
			load_data(1, limit, filter, sort_by);
		});

		// submit di klik
		$('input[name="submit"]').on('click', function (e) {
			e.preventDefault();

			empty_data();

			filter.title = $('input[name="title"]').val();
			filter.publisher_id = $('select[name="publisher"]').val();
			filter.author = $('input[name="author"]').val();
			filter.category_ids = $('select[name="category_id"]').val();
			filter.year = $('input[name="start_year"]').val() + '-' + $('input[name="end_year"]').val();

			load_data(1, limit, filter, sort_by);
		});

		// select sort-by di ubah
		$('select[name="sort-by"]').on('change', function (e) {
			e.preventDefault();

			empty_data();

			sort_by = $(this).val();
			load_data(1, limit, filter, sort_by);
		});
		
		// tampilan list di klik
		$('.list').on('click', function (e) {
			e.preventDefault();

			empty_data();

			view_style = 'list';
			load_data(1, limit, filter, sort_by);
		});

		// tampilan grid di klik
		$('.grid').on('click', function (e) {
			e.preventDefault();

			empty_data();

			view_style = 'grid';
			load_data(1, limit, filter, sort_by);
		});



	});
</script>
