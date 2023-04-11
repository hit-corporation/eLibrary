<?php $this->layout('layouts::main_template', ['title' => 'Book Order'])?>


<!-- CSS SECTION -->
<?php $this->start('css') ?>

<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/@selectize/selectize/dist/css/selectize.bootstrap4.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">

<style>

    .card-header {
        background-color: var(--primary);
        color: var(--white);
    }

    .table td {
        border: none;
    }

    .table tr {
        border-top: 1px solid #e3e6f0;
        margin-top: .4rem;
    }

    .w-max-content {
       width: max-content; 
    }

    @media (min-width: 992px) {
        .d-lg-table-head {
            display: table-header-group !important;
        }

        .table td {
            border-top: 1px solid #e3e6f0;
        }

        .table tr {
            border: none;
            margin: 0px;
        }
    }

</style>

<?php $this->stop() ?>

<!-- CONTENT SECTION -->
<?php $this->start('contents') ?>

<div class="container-fluid col-12">
    <div class="row">
        <!-- <form name="form-input" method="POST" action="<? //=$this->e(base_url('order/store'))?>" class="col-12"> -->
		<div class="col-12">

			
			
            <div class="d-sm-flex align-items-center justify-content-between mb-3 px-2 w-100">
                <h1 class="h3 mb-0 text-gray-800"><?=$this->e('Formulir Pengembalian Buku')?></h1>
                <span class="ml-auto d-flex flex-nowrap justify-content-end">
                    <!-- <button type="reset" class="btn btn-sm btn-secondary"><i class="fas fa-sync"></i> Ulangi</button> -->
                    
                </span>
            </div>
        
            <div class="form-row">
                <!-- START MEMBER FIELDS-->
                <fieldset class="col-12">
                   <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="mb-0">Anggota</h4>
                        </div>
                        <div class="card-body">

							<!-- left -->
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="" class="form-label mb-0">Scan Kartu<span class="text-danger">*</span></label>
										<input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['card_no'])): ?> is-invalid <?php endif ?>" id="card_no" name="card_no" value="<?=$_SESSION['error']['old']['card_no'] ??  NULL ?>" autofocus="on">
										<?php if(!empty($_SESSION['error']['errors']['card_no'])): ?>
											<small class="text-danger"><?=$_SESSION['error']['errors']['card_no']?></small>
										<?php endif ?>
									</div>

									<div class="form-group mt-3" id="member-group">
										<label for="" class="form-label mb-0">Nama Anggota<span class="text-danger">*</span></label>
										<select class="form-control <?php if(!empty($_SESSION['error']['errors']['member'])): ?> is-invalid <?php endif ?>" name="member" value="<?=$_SESSION['error']['old']['member'] ?? NULL ?>"></select>
										<?php if(!empty($_SESSION['error']['errors']['member'])): ?>
											<small class="text-danger"><?=$_SESSION['error']['errors']['member']?></small>
										<?php endif ?>
									</div>

									<input type="hidden" id="member-id">
								</div>


								<!-- right -->
								<div class="col-6 p-3" id="member-info">
									<div class="container p-2 rounded-lg border">
										<h5 class="text-center">Informasi</h5>
										<table class="ml-3 mb-3">
											<tr>
												<td class="pr-3">Nama</td>
												<td>:</td>
												<td id="member-name"></td>
											</tr>
											<tr>
												<td class="pr-3">NIS</td>
												<td>:</td>
												<td id="member-nis"></td>
											</tr>
											<tr>
												<td class="pr-3">Kelas</td>
												<td>:</td>
												<td id="member-kelas"></td>
											</tr>
										</table>
									</div>
								</div>

							</div>

							
							
							
							
							

							
                        </div>
                   </div>
                </fieldset>
                <!-- END MEMBER FIELDS -->
				<form method="POST" action="order/return_order" class="col-12" id="return-order-form">
					<!-- START BOOK FIELD-->
					<fieldset>
						<div class="card">
							<div class="card-header d-flex flex-nowrap">
								<h4 class="mb-0">Buku</h4>
							
							</div>
							<div class="card-body pt-0 px-0">
								<table id="book-orders" class="table table-sm w-100">
									<thead class="bg-primary text-white d-none d-lg-table-head">
										<tr>
											<th class="pl-2" style="width: 20%">Kode Buku <span class="text-danger">*</span></th>
											<th class="pl-2" style="width: 50%">Judul <span class="text-danger">*</span></th>
											<th class="pl-2">Tgl Pinjam <span class="text-danger">*</span></th>
											<th class="pl-2">Tgl Kembali <span class="text-danger">*</span></th>
											<th class="pl-2">Denda <span class="text-danger">*</span></th>
											<th class="pl-2">Pilih</th>
										</tr>
									</thead>
									<tbody id="book-orders-body">
										
										
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
					<!-- END BOOK FIELDS -->
					
					<!-- start total denda -->
					<fieldset>
						<div class="card mt-3 p-3">
							
							<div class="card-body pt-0 px-0">
								<div class="form-group">
									<label for="" class="form-label mb-0">Total Denda</label>
									<input type="text" class="form-control" id="fines" name="fines" value="0" readonly>
								</div>

								<div class="row">
									<div class="form-group col-6">
										<label for="" class="form-label mb-0">Jumlah Bayar</label>
										<input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" value="0">
									</div>

									<div class="form-group col-6">
										<label for="" class="form-label mb-0">Jenis Pembayaran</label>
										<select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
											<option value="cash">Cash</option>
											<option value="pemutihan">Pemutihan</option>
										</select>
									</div>
								</div>

								<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
							</div>
							
						</div>
					</fieldset>
					<!-- end total denda -->
					

				</form>
            </div>
		</div>
        <!-- </form> -->
    </div>
</div>



<?php $this->stop() ?>

<!-- JS SECTION -->
<?php $this->start('js') ?>
<script src="<?=$this->e(base_url('assets/node_modules/@selectize/selectize/dist/js/selectize.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/bootstrap-4-autocomplete/dist/bootstrap-4-autocomplete.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

<script src="<?=$this->e(base_url('assets/js/pages/returnOrder.js'))?>"></script>

<?php $this->stop() ?>

