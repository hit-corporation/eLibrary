<?php $this->layout('layouts::admin_template', ['title' => 'Publisher'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>

<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">

<?php $this->stop() ?>



<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

	<!-- Begin Page Content -->
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">User</h1>
			<button id="btn-add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modal-input" >
				<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
			</button>
		</div>

		<!-- Content Row -->
		<!-- <div class="row"> -->

			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6">
							<h6 class="m-0 font-weight-bold text-primary">List Data User</h6>

						</div>
						<div class="col-xl-6 col-lg-6 col-md-6">
							<form name="form-search">
								<div class="row">
									<div class="col-10">
										<input type="text" class="form-control form-control-sm" name="s_user_name" placeholder="Nama User">
									</div>
									<div class="col-2">
										<div class="btn-group btn-group-sm">
											<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
											<button type="reset" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>


				<div class="card-body">
					<div class="table-responsive">
						<table id="table-main" class="table table-sm table-striped" width="100%">
							<thead class="bg-primary text-white">
								<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>User Pass</th>
									<th>Role Name</th>
									<th>Role Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							
						</table>
					</div>
				</div>
			</div>

		
		<!-- </div> -->

	</div>
	<!-- /.container-fluid -->

	<div id="modal-input" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title">Add / Edit Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form-input" name="form-input" method="POST" action="<?=base_url('user/store')?>">
						<input type="text" class="d-none" name="user_id">
						<div class="form-group">
							<label>User Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['user_name'])):?> is-invalid <?php endif ?>" 
								name="user_name" value="<?=$_SESSION['error']['old']['user_name'] ?? ''?>" required>
							
							<?php if(!empty($_SESSION['error']['errors']['user_name'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['user_name']?></small>
							<?php endif ?>
						</div>
						
						<div class="form-group">
							<label>Full Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['full_name'])):?> is-invalid <?php endif ?>" 
								name="full_name" value="<?=$_SESSION['error']['old']['full_name'] ?? ''?>" required>
							
							<?php if(!empty($_SESSION['error']['errors']['full_name'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['full_name']?></small>
							<?php endif ?>
						</div>

						<div class="form-group">
							<label>Email </label>
							<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['email'])):?> is-invalid <?php endif ?>" 
								name="email" value="<?=$_SESSION['error']['old']['email'] ?? ''?>">
							
							<?php if(!empty($_SESSION['error']['errors']['email'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['email']?></small>
							<?php endif ?>
						</div>

						<div class="form-group">
							<label>Password </label>
							<input type="password" class="form-control <?php if(!empty($_SESSION['error']['errors']['user_pass'])):?> is-invalid <?php endif ?>" 
								name="user_pass" value="<?=$_SESSION['error']['old']['user_pass'] ?? ''?>" required>
							
							<?php if(!empty($_SESSION['error']['errors']['user_pass'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['user_pass']?></small>
							<?php endif ?>
						</div>

						<div class="form-group">
							<label for="role_id">Role Name</label>
							<select class="form-control" id="role_id" name="role_id">
							</select>
						</div>

						<div class="form-group">
							<label for="status">Status</label>
							<select class="form-control" id="status" name="status">
								<option value="active">active</option>
								<option value="inactive">inactive</option>
							</select>
						</div>

						<div class="row justify-content-end mt-4 border-top pt-3 px-2">
							<button type="reset" class="btn btn-secondary"><i class="fas fa-sync"></i> Ulangi</button>
							<button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i> Simpan</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


<?php $this->stop() ?>

<!-- SECTION JS -->
<?php $this->start('js') ?>

<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>

<?php if(isset($_SESSION['error'])): ?>
<script>
   $('#modal-input').modal('show');
</script>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
<script>
   
    Swal.fire({
        icon: 'success',
        title: '<h4 class="text-success">SUKSES</h4>',
        html: '<h5 class="text-success"><?=$_SESSION['success']['message']?></h5>',
        timer: 1500
    });

</script>
<?php endif; ?>

<script src="<?=$this->e(base_url('assets/js/pages/users.js'))?>"></script>

<?php $this->stop() ?>
