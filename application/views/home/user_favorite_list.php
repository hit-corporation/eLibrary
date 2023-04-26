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
					<div class="user-information">
						<div class="user-img">
							<a href="#"><img src="<?= isset($user['profile_img']) ? base_url('assets/landing-pages/images/avatar/'.$user['profile_img']) : base_url('assets/landing-pages/images/uploads/user-img.png') ?>" alt=""><br></a>
							<a href="#" class="redbtn" id="change-avatar">Change avatar</a>
						</div>
						<div class="user-fav">
							<p>Account Details</p>
							<ul>
								<li><a href="<?=base_url('user')?>#user-profile">Profile</a></li>
								<li  class="active"><a href="<?=base_url('user/user_favorite_list')?>">Favorite Books</a></li>
							</ul>
						</div>
						<div class="user-fav">
							<p>Others</p>
							<ul>
								<li><a href="<?=base_url('user')?>#change-password">Change password</a></li>
								<li><a href="<?=base_url('user/logout')?>">Log out</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="topbar-filter user">
						<p>Found <span><?=count($favorite_books)?> books</span> in total</p>
						<label>Sort by:</label>
						<select>
							<option value="range">-- Choose option --</option>
							<option value="saab">-- Choose option 2--</option>
						</select>
						<a href="userfavoritelist.html" class="list"><i class="ion-ios-list-outline active"></i></a>
						<a  href="userfavoritegrid.html" class="grid"><i class="ion-grid "></i></a>
					</div>
					<div class="flex-wrap-movielist user-fav-list">

						<?php foreach($favorite_books as $key => $val):?>
						<div class="movie-item-style-2">
							<img src="<?=base_url('assets/img/books/').$val['cover_img']?>" alt="">
							<div class="mv-item-infor">
								<h6><a href="#"><?=$val['title']?> <span>(<?=$val['publish_year']?>)</span></a></h6>
								<p class="describe"><?=substr($val['description'], 0, 300)?>...</p>

								<a class="btn btn-xs btn-primary" href="<?=base_url('User/delete_favorite_book?id=').$val['id']?>">Delete Favorite</a>
								
								<p>Penulis: <a href="#"><?=$val['author']?></a></p>
								<p>ISBN: <a href="#"><?=$val['isbn']?></a></p>
								<p>Penerbit: <a href="#"><?=$val['publisher_name']?></a></p>
								<p>Kategori: <a href="#"><?=$val['category_name']?></a></p>
							</div>
						</div>
						<?php endforeach;?>

					</div>		
					<div class="topbar-filter">
						<label>Movies per page:</label>
						<select>
							<option value="range">5 Movies</option>
							<option value="saab">10 Movies</option>
						</select>
						
						<div class="pagination2">
							<span>Page 1 of 2:</span>
							<a class="active" href="#">1</a>
							<a href="#">2</a>
							<a href="#">3</a>
							<a href="#">...</a>
							<a href="#">78</a>
							<a href="#">79</a>
							<a href="#"><i class="ion-arrow-right-b"></i></a>
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


</script>
