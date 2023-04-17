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
<div class="page-single">
	<div class="container">
		<div class="row ipad-width">
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div class="user-information">
					<div class="user-img">
						<a href="#"><img src="<?=base_url()?>assets/landing-pages/images/uploads/user-img.png" alt=""><br></a>
						<a href="#" class="redbtn">Change avatar</a>
					</div>
					<div class="user-fav">
						<p>Account Details</p>
						<ul>
							<li  class="active"><a href="userprofile.html">Profile</a></li>
							<li><a href="<?=base_url('home/user_favorite_list')?>">Favorite movies</a></li>
						</ul>
					</div>
					<div class="user-fav">
						<p>Others</p>
						<ul>
							<li><a href="#">Change password</a></li>
							<li><a href="<?=base_url('user/logout')?>">Log out</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-sm-12 col-xs-12">
				<div class="form-style-1 user-pro" action="#">
					<form action="<?=base_url('user')?>" method="POST" class="user">
						<h4>01. Profile details</h4>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Nama Lengkap</label>
								<input type="hidden" name="id" value="<?=$user['id']?>">
								<input type="text" placeholder="Masukan Nama Lengkap" name="member_name" value="<?=$user['member_name']?>">
							</div>
							<div class="col-md-6 form-it">
								<label>Username</label>
								<input type="text" placeholder="Masukan Username" name="username" value="<?=$user['username']?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Nomor Induk</label>
								<input type="text" placeholder="Masukan Nomor Induk" name="no_induk" value="<?=$user['no_induk']?>">
							</div>
							<div class="col-md-6 form-it">
								<label>Nomor Kartu</label>
								<input type="text" placeholder="Masukan Nomor Kartu" name="card_number" value="<?=$user['card_number']?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Kelas</label>
								<select name="kelas">
								  <option value="">-- Pilih --</option>
								  <?php for($i=1; $i<=12; $i++): ?>
								  	<option value="<?=$i?>" <?=($user['kelas'] == $i) ? 'selected' : ''?>><?=$i?></option>
								  <?php endfor; ?>
								</select>
							</div>
							<div class="col-md-6 form-it">
								<label>Email</label>
								<input type="text" placeholder="Masukan Email" name="email" value="<?=$user['email']?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Telp</label>
								<input type="text" placeholder="Masukan Nomor Telepon" name="phone" value="<?=$user['phone']?>">
							</div>
							<div class="col-md-6 form-it">
								<label>Alamat</label>
								<textarea type="text" rows="3" placeholder="Masukan Alamat" name="address"><?=$user['address']?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<input class="submit" type="submit" name="save_profile">
							</div>
						</div>	
					</form>
					<form action="<?=base_url('user/change_password')?>" method="POST" class="password">
						<h4>02. Change password</h4>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Old Password</label>
								<input type="password" name="old_password" placeholder="Masukan Password Lama">
								<!-- error -->
								<?php if(!empty($_SESSION['error'])) : ?>
									<span class="text-danger-input"><?= isset($_SESSION['error']['message']['old_password']) ? $_SESSION['error']['message']['old_password'] : null ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>New Password</label>
								<input type="password" name="new_password" placeholder="***************">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-it">
								<label>Confirm New Password</label>
								<input type="password" name="confirm_password" placeholder="*************** ">
								<!-- error -->
								<?php if(!empty($_SESSION['error'])) : ?>
									<span class="text-danger-input"><?= isset($_SESSION['error']['message']['confirm_password']) ? $_SESSION['error']['message']['confirm_password'] : null ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<input class="submit" type="submit" name="change_password">
							</div>
						</div>	
					</form>
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

</script>
