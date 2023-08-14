<style>
	.swal-wide{
		width:400px !important;
	}
</style>

<div class="hero mv-single-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- <h1> movie listing - list</h1>
				<ul class="breadcumb">
					<li class="active"><a href="#">Home</a></li>
					<li> <span class="ion-ios-arrow-right"></span> movie listing</li>
				</ul> -->
			</div>
		</div>
	</div>
</div>
<div class="page-single movie-single movie_single">
	<div class="container">
		<div class="row ipad-width2">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="movie-img sticky-sb">
					<img src="<?php
						if (isset($book['cover_img'])){
							if(file_exists(FCPATH.'/assets/img/books/'.$book['cover_img'])){
								echo base_url('assets/img/books/').$book['cover_img'];
							}else{
								echo base_url('assets/img/books/default.png');
							}
						}else{
							echo base_url('assets/img/books/default.png');
						}
					?>" alt="">
					<div class="movie-btn">	

						<!-- jika user telah login dan buku sudah di pinjam -->
						<?php if(isset($transaction)):?>

						<div class="btn-transform transform-vertical red">				
							<div><a href="#" class="item item-1 redbtn"> <i class="ion-eye"></i> Read</a></div>
							<div><a href="<?=base_url('book/set_book?id='.trim($_GET['id']))?>" class="item item-2 redbtn fancybox-media hvr-grow"><i class=""></i>Click To Read</a></div>
						</div>

						<!-- button return book -->
						<div class="btn-transform transform-vertical blue">				
							<div><a href="#" class="item item-1 bluebtn">Return</a></div>
							<div><a href="<?=base_url('book/return_book?id='.trim($_GET['id']))?>" class="item item-2 bluebtn fancybox-media hvr-grow"></i>Click To Return</a></div>
						</div>


						<?php else:?>

						<div class="btn-transform transform-vertical blue">				
							<div><a href="#" class="item item-1 bluebtn">Borrow</a></div>
							<div><a href="<?=base_url('book/borrow_book?id='.trim($_GET['id']))?>" class="item item-2 bluebtn fancybox-media hvr-grow"></i>Click To Borrow</a></div>
						</div>
						<?php endif;?>
						
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
				<div class="movie-single-ct main-content">
					<h1 class="bd-hd"><?=$book['title']?> <span><?=$book['publish_year']?></span></h1>
					
					
					<div class="movie-tabs">
						<div class="tabs">
							<ul class="tab-links tabs-mv">
								<li class="active"><a href="#overview">Overview</a></li>
								<!-- <li><a href="#reviews"> Reviews</a></li>                -->
							</ul>
						    <div class="tab-content">
						        <div id="overview" class="tab active">
						            <div class="row">
						            	<div class="col-md-8 col-sm-12 col-xs-12">
						            		<p style="white-space: pre-line"><?=$book['description']?></p>
						            		
										
						            	</div>
						            	<div class="col-md-4 col-xs-12 col-sm-12">

											<div class="sb-it">
												<!-- jika user belum login maka hide button add favorite -->
												<?php if(isset($_SESSION['user'])):?>
													<!-- jika buku sudah ada di favorite -->
													<?php if(isset($favorite)):?>
														<a href="<?=base_url('book/remove_from_favorite?id=').$book['id']?>" class="btn btn-xs bluebtn btn-primary btn-add-favorite"><i class="fa fa-minus"></i><span>Delete Favorite</span></a>
													<?php else:?>
														<!-- jika buku belum ada di favorite -->
														<a href="<?=base_url('book/add_to_favorite?id=').$book['id']?>" class="btn btn-xs bluebtn btn-primary btn-add-favorite"><i class="fa fa-plus"></i><span>Add Favorite</span></a>
													<?php endif;?>

												<?php endif;?>
											</div>

											<div class="sb-it">
						            			<h6>Penulis: </h6>
						            			<p><a href="#"><?=$book['author']?></a></p>
						            		</div>
						            		<div class="sb-it">
						            			<h6>Penerbit: </h6>
						            			<p><a href="#"><?=$book['publisher_name']?></a></p>
						            		</div>
						            		<div class="sb-it">
						            			<h6>Isbn: </h6>
						            			<p><a href="#"><?=$book['isbn']?></a></p>
						            		</div>
						            		<div class="sb-it">
						            			<h6>Tahun Terbit: </h6>
						            			<p><a href="#"><?=$book['publish_year']?></a></p>
						            		</div>

						            		<div class="sb-it">
						            			<h6>Kategori: </h6>
						            			<p><?=$book['category_name']?></p>
						            		</div>
						            		
						            		
						            		
						            	</div>
						            </div>
						        </div>

						        <div id="reviews" class="tab review active">
						           <div class="row" style="margin-left:0px">
						            	<!-- <div class="rv-hd">
						            		<div class="div">
							            	</div>
											
							            	<a href="#" class="redbtn">Write Review</a>
						            	</div> -->
						            	<div class="topbar-filter">
											<p>Found <span id="total-review"></span> in total</p>
											<label>Filter by:</label>
											<select id="order-by-rating">
												<option value="create-at-desc">Created Desc</option>
												<option value="create-at-asc">Created Asc</option>
												<option value="rating-asc">Rating Asc</option>
												<option value="rating-desc">Rating Desc</option>
											</select>
										</div>

										<div class="user-review-content"></div>

										<div class="topbar-filter">
											<label>Reviews per page:</label>
											<select class="view-per-page">
												<option value="5">	5 Reviews</option>
												<option value="10">10 Reviews</option>
												<option value="25">25 Reviews</option>
												<option value="50">50 Reviews</option>
											</select>
											<div class="pagination2">
												<span>Page 0 of 0:</span>
												<div class="page-number" style="display: inline;">
													<!-- <a class="active" href="#">1</a> -->
													<!-- <a href="#">2</a>
													<a href="#">3</a>
													<a href="#">4</a>
													<a href="#">5</a>
													<a href="#">6</a> -->
													<!-- <a href="#"><i class="ion-arrow-right-b"></i></a> -->
												</div>
											</div>
										</div>

						            </div>
						        </div>
						        
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		<?php if(isset($_SESSION['success'])) : ?>
			Swal.fire({
            icon: 'success',
            title: '<?=$_SESSION['success']?>',
            timer: 2000,
			customClass: 'swal-wide',
        });

		
		<?php unset($_SESSION['success']); ?>
		<?php endif; ?>

		
		rating_by_book_id(1, 5, 'create-at-desc', bookId);
	});

	var bookId = <?=$book['id']?>;

	function rating_by_book_id(page, limit = '', sort_by = '', book_id){
		$.ajax({
			type: "POST",
			url: BASE_URL + "book/rating_by_book_id",
			data: {
				sort_by: sort_by,
				page: page,
				limit: limit,
				book_id, book_id
			},
			dataType: "JSON",
			success: function (response) {
				if(response.success == true){
					// DELETE CONTENT USER REVIEW, PAGE NUMBER
					$('.user-review-content').html('');
					$('.page-number').html('');

					$.each(response.data, function (i, val) {
						// LOOPING CONTENT REVIEW
						$('.user-review-content').append(`
							<div class="mv-user-review-item">
								<div class="user-infor">
									<img src="${(val.profile_img != undefined) ? val.profile_img : BASE_URL+`assets/landing-pages/images/uploads/user-img.png` }" alt="">
									<div>
										<h3>${val.member_name}</h3>
										<div class="no-star">
											${star(val.rating)}
										</div>
										<p class="time">
											${val.created_at}
										</p>
									</div>
								</div>
								<p>${val.notes}</p>
							</div>
						`);
					});

					// UBAH ANGKA TOTAL REVIEW
					$('#total-review').text(response.total_records);
						// UBAH SPAN PAGINATION12
						$('.pagination2')[0].firstElementChild.innerHTML = `Page ${page} of ${response.total_pages}`;

					// LOOPING page-number
					for(let i = 0; i < response.total_pages; i++){
						$('.page-number').append(`
							<a onclick="pageNumberClick(this)">${i+1}</a>
						`);
					}
					// append terakhir di class page number untuk menampilan arrow right
					$('.page-number').append(`
						<a href="#"><i class="ion-arrow-right-b"></i></a>
					`);

				}
			}
		});
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

</script>
