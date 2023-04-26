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
						<p>Found <span>1,608 movies</span> in total</p>
						<label>Sort by:</label>
						<select>
							<option value="range">-- Choose option --</option>
							<option value="saab">-- Choose option 2--</option>
						</select>
						<a href="userfavoritelist.html" class="list"><i class="ion-ios-list-outline active"></i></a>
						<a  href="userfavoritegrid.html" class="grid"><i class="ion-grid "></i></a>
					</div>
					<div class="flex-wrap-movielist user-fav-list">
						<div class="movie-item-style-2">
							<img src="<?=base_url()?>assets/landing-pages/images/uploads/mv1.jpg" alt="">
							<div class="mv-item-infor">
								<h6><a href="#">oblivion <span>(2012)</span></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>8.1</span> /10</p>
								<p class="describe">Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity...</p>
								<p class="run-time"> Run Time: 2h21’    .     <span>MMPA: PG-13 </span>    .     <span>Release: 1 May 2015</span></p>
								<p>Director: <a href="#">Joss Whedon</a></p>
								<p>Stars: <a href="#">Robert Downey Jr.,</a> <a href="#">Chris Evans,</a> <a href="#">  Chris Hemsworth</a></p>
							</div>
						</div>
						<div class="movie-item-style-2">
							<img src="<?=base_url()?>assets/landing-pages/images/uploads/mv2.jpg" alt="">
							<div class="mv-item-infor">
								<h6><a href="#">into the wild <span>(2014)</span></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>7.8</span> /10</p>
								<p class="describe">As Steve Rogers struggles to embrace his role in the modern world, he teams up with a fellow Avenger and S.H.I.E.L.D agent, Black Widow, to battle a new threat...</p>
								<p class="run-time"> Run Time: 2h21’    .     <span>MMPA: PG-13 </span>    .     <span>Release: 1 May 2015</span></p>
								<p>Director: <a href="#">Anthony Russo,</a><a href="#">Joe Russo</a></p>
								<p>Stars: <a href="#">Chris Evans,</a> <a href="#">Samuel L. Jackson,</a> <a href="#">  Scarlett Johansson</a></p>
							</div>
						</div>
						<div class="movie-item-style-2">
							<img src="<?=base_url()?>assets/landing-pages/images/uploads/mv3.jpg" alt="">
							<div class="mv-item-infor">
								<h6><a href="#">blade runner  <span>(2015)</span></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>7.3</span> /10</p>
								<p class="describe">Armed with a super-suit with the astonishing ability to shrink in scale but increase in strength, cat burglar Scott Lang must embrace his inner hero and help...</p>
								<p class="run-time"> Run Time: 2h21’    .     <span>MMPA: PG-13 </span>    .     <span>Release: 1 May 2015</span></p>
								<p>Director: <a href="#">Peyton Reed</a></p>
								<p>Stars: <a href="#">Paul Rudd,</a> <a href="#"> Michael Douglas</a></p>
							</div>
						</div>
						<div class="movie-item-style-2">
							<img src="<?=base_url()?>assets/landing-pages/images/uploads/mv4.jpg" alt="">
							<div class="mv-item-infor">
								<h6><a href="#">Mulholland pride<span> (2013)  </span></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>7.2</span> /10</p>
								<p class="describe">When Tony Stark's world is torn apart by a formidable terrorist called the Mandarin, he starts an odyssey of rebuilding and retribution.</p>
								<p class="run-time"> Run Time: 2h21’    .     <span>MMPA: PG-13 </span>    .     <span>Release: 1 May 2015</span></p>
								<p>Director: <a href="#">Shane Black</a></p>
								<p>Stars: <a href="#">Robert Downey Jr., </a> <a href="#">  Guy Pearce,</a><a href="#">Don Cheadle</a></p>
							</div>
						</div>
						<div class="movie-item-style-2">
							<img src="<?=base_url()?>assets/landing-pages/images/uploads/mv5.jpg" alt="">
							<div class="mv-item-infor">
								<h6><a href="#">skyfall: evil of boss<span> (2013)  </span></a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>7.0</span> /10</p>
								<p class="describe">When Tony Stark's world is torn apart by a formidable terrorist called the Mandarin, he starts an odyssey of rebuilding and retribution.</p>
								<p class="run-time"> Run Time: 2h21’    .     <span>MMPA: PG-13 </span>    .     <span>Release: 1 May 2015</span></p>
								<p>Director: <a href="#">Alan Taylor</a></p>
								<p>Stars: <a href="#">Chris Hemsworth,  </a> <a href="#">  Natalie Portman,</a><a href="#">Tom Hiddleston</a></p>
							</div>
						</div>
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
