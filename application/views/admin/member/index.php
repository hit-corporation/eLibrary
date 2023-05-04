<?php $this->layout('layouts::admin_template', ['title' => 'Kategori'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>
<link href="<?=$this->e(base_url('assets/vendor/jstree/dist/themes/default/style.min.css'))?>" rel="stylesheet">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">
<style>
#tree-container {
    height: 240px;
    overflow: auto;
}
</style>
<?php $this->stop() ?>

<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

<div class="row">
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between pb-2 mb-3 px-2 border-bottom">
			<h1 class="h3 mb-0 text-gray-800">Member</h1>
			
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
						<a role="button" class="dropdown-item" href="<?=$this->e(base_url('assets/files/download/template/member_template.xlsx'))?>" download>Unduh Berkas Templat</a>
						<a role="button" class="dropdown-item" data-target="#modal-import" data-toggle="modal">Unggah Dari Templat Excel</a>
					</div>
				</div>
			</div>
			
		</div>

        <div class="card">
			<div class="card-header py-3">
				
				<form name="form-search">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<input type="text" class="form-control form-control-sm" name="s_card_number" placeholder="Nomor Kartu">
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<input type="text" class="form-control form-control-sm" name="s_no_induk" placeholder="Nomor Induk">
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<input type="text" class="form-control form-control-sm" name="s_member_name" placeholder="Nama Member">
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

            <div class="card-body">
                <div class="table-reponsive" style="overflow:auto">
					<table id="table-main" class="table table-sm table-striped" width="100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Nama Member</th>
                                <th>Username</th>
                                <th>password</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor Kartu</th>
                                <th>Nomor Induk</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div id="modal-input" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-input" name="form-input" method="POST" action="<?=base_url('member/store')?>">
                    <input type="text" class="d-none" name="member_id">
                    <div class="form-group">
                        <label>Nama Member <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['member_name'])):?> is-invalid <?php endif ?>" 
                              name="member_name" value="<?=$_SESSION['error']['old']['member_name'] ?? ''?>" required>
                        
                        <?php if(!empty($_SESSION['error']['errors']['member_name'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['member_name']?></small>
                        <?php endif ?>
                    </div>
                    
					<div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['username'])):?> is-invalid <?php endif ?>" 
                              name="username" value="<?=$_SESSION['error']['old']['username'] ?? ''?>" required>
                        
                        <?php if(!empty($_SESSION['error']['errors']['username'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['username']?></small>
                        <?php endif ?>
                    </div>

					<div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?php if(!empty($_SESSION['error']['errors']['password'])):?> is-invalid <?php endif ?>" 
                              name="password" value="<?=$_SESSION['error']['old']['password'] ?? ''?>" required>
                        
                        <?php if(!empty($_SESSION['error']['errors']['password'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['password']?></small>
                        <?php endif ?>
                    </div>

					<div class="form-group">
						<label>Jenis Kelamin <span class="text-danger">*</span></label>
						<div class="form-control border-0 p-0">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="jenis_kelamin" id="inlineRadio1" value="l" checked>
								<label class="form-check-label" for="inlineRadio1">Laki-laki</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="jenis_kelamin" id="inlineRadio2" value="p">
								<label class="form-check-label" for="inlineRadio2">Perempuan</label>
							</div>
						</div>
                    </div>

					<div class="form-group">
                        <label>No Kartu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['card_number'])):?> is-invalid <?php endif ?>" 
                              name="card_number" value="<?=$_SESSION['error']['old']['card_number'] ?? ''?>">
                        
                        <?php if(!empty($_SESSION['error']['errors']['card_number'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['card_number']?></small>
                        <?php endif ?>
                    </div>
                    
					<div class="form-group">
                        <label>No Induk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['no_induk'])):?> is-invalid <?php endif ?>" 
                              name="no_induk" value="<?=$_SESSION['error']['old']['no_induk'] ?? ''?>" required>
                        
                        <?php if(!empty($_SESSION['error']['errors']['no_induk'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['no_induk']?></small>
                        <?php endif ?>
                    </div>

					<div class="form-group">
                        <label>Email </label>
                        <input type="email" class="form-control <?php if(!empty($_SESSION['error']['errors']['email'])):?> is-invalid <?php endif ?>" 
                              name="email" value="<?=$_SESSION['error']['old']['email'] ?? ''?>">
                        
                        <?php if(!empty($_SESSION['error']['errors']['email'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['email']?></small>
                        <?php endif ?>
                    </div>
					
					<div class="form-group">
                        <label>Alamat </label>
						<textarea class="form-control <?php if(!empty($_SESSION['error']['errors']['address'])):?> is-invalid <?php endif ?>" name="address" id="" cols="30" rows="3" value="<?=$_SESSION['error']['old']['address'] ?? ''?>"></textarea>
							
						<?php if(!empty($_SESSION['error']['errors']['address'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['address']?></small>
                        <?php endif ?>
                    </div>

					<div class="form-group">
                        <label>Telp </label>
                        <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['phone'])):?> is-invalid <?php endif ?>" 
                              name="phone" value="<?=$_SESSION['error']['old']['phone'] ?? ''?>">
                        
                        <?php if(!empty($_SESSION['error']['errors']['phone'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['phone']?></small>
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
            <form name="form-input" action="<?=$this->e(base_url('admin/member/import'))?>" class="modal-body" method="POST" enctype="multipart/form-data">
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

<?php $this->stop() ?>

<!-- SECTION JS -->
<?php $this->start('js') ?>
<!-- <script src="<? // =$this->e(base_url('assets/vendor/jstree/dist/jstree.min.js'))?>"></script> -->
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

<script src="<?=$this->e(base_url('assets/js/pages/members.js'))?>"></script>







<?php $this->stop() ?>
