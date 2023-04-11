<?php $this->layout('layouts::main_template', ['title' => 'Publisher'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>

<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">

<?php $this->stop() ?>

<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

<!-- CONTENT -->
<!-- <div class="container"> -->
	<div class="row">

		<!-- Begin Page Content -->
		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="d-sm-flex align-items-center justify-content-between pb-2 mb-3 px-3">
				<h1 class="h3 mb-0 text-gray-800">Penerbit</h1>

				<div class="row">
					<button id="btn-add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#modal-input" >
						<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
					</button>
	
					<div class="dropdown">
						<button id="btn-import" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-download" aria-hidden="true"></i> 
							Import Data
						</button>
						<div class="dropdown-menu">
							<a role="button" class="dropdown-item" href="<?=$this->e(base_url('assets/files/download/template/publisher_template.xlsx'))?>" download>Unduh Berkas Templat</a>
							<a role="button" class="dropdown-item" data-target="#modal-import" data-toggle="modal">Unggah Dari Templat Excel</a>
						</div>
					</div>
				</div>
				
			</div>

			<!-- Content Row -->
			<!-- <div class="row"> -->

				<!-- DataTales Example -->
				<div class="card shadow mb-4">

					<div class="card-header py-3">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6">
								<h6 class="m-0 font-weight-bold text-primary">List Data Penerbit</h6>

							</div>
							<div class="col-xl-6 col-lg-6 col-md-6">
								<form name="form-search">
									<div class="row">
										<div class="col-10">
											<input type="text" class="form-control form-control-sm" name="s_publisher_name" placeholder="Nama Penerbit">
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
										<th>Nama Penerbit</th>
										<th>Alamat</th>
										<th>Tanggal Dibuat</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>

		</div>
		<!-- /.container-fluid -->

	</div>

	<div id="modal-input" class="modal fade" tabindex="-1">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title">Tambah Penerbit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form-input" name="form-input" method="POST" action="<?=base_url('publisher/store')?>">
						<input type="text" class="d-none" name="publisher_id">

						<div class="form-group">
							<label>Nama Penerbit <span class="text-danger">*</span></label>
							<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['publisher_name'])):?> is-invalid <?php endif ?>" 
								name="publisher_name" value="<?=$_SESSION['error']['old']['publisher_name'] ?? ''?>" required>
							
							<?php if(!empty($_SESSION['error']['errors']['publisher_name'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['publisher_name']?></small>
							<?php endif ?>
						</div>

						<div class="form-group">
							<label>Alamat </label>
							<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['address'])):?> is-invalid <?php endif ?>" 
								name="address" value="<?=$_SESSION['error']['old']['address'] ?? ''?>">
							
							<?php if(!empty($_SESSION['error']['errors']['address'])): ?>
								<small class="text-danger"><?=$_SESSION['error']['errors']['address']?></small>
							<?php endif ?>
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

	<!-- modal import -->
	<div id="modal-import" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header bg-indigo text-white">
					<h5 class="modal-title">Import Data Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form name="form-input" action="<?=$this->e(base_url('publisher/import'))?>" class="modal-body" method="POST" enctype="multipart/form-data">
					<fieldset class="row">
						<div class="col-12">
							<span>* Data harus beformat ms. excel / xlsx</span>
							<br>
							<span>* Data harus memiliki sususanan nama kolom yang sesuai</span>
							<br>
							<span>* Data tidak bisa lebih dari 5000 data</span>
							<br>
							<div class="form-group row mt-3 border rounded-lg mx-3 shadow">
								<label class="col-sm-2 col-form-label">File Excel</label>
								<div class="col-sm-10">
									<input type="file" name="file" class="my-2" required>
								</div>
							</div>
							
						</div>
						
					</fieldset>
					<fieldset class="row justify-content-end mt-4 border-top pt-3 px-2">
						<button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-sync"></i> Ulangi</button>
						<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-save"></i> Simpan</button>
					</fieldset>
				</form>

			</div>
		</div>
	</div>

<!-- </div> -->


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

<?php if(isset($_SESSION['error']['message'])): ?>
<script>
   
    Swal.fire({
        icon: 'error',
        title: '<h4 class="text-danger">GAGAL</h4>',
        html: '<h5 class="text-danger"><?=$_SESSION['error']['message']?></h5>',
        timer: 1500
    });

</script>
<?php endif; ?>

<script src="<?=$this->e(base_url('assets/js/pages/publishers.js'))?>"></script>

<?php $this->stop() ?>
