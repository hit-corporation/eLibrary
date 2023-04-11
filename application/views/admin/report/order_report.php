<?php $this->layout('layouts::admin_template', ['title' => 'Kategori'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>
<link rel="stylesheet" type="text/css" href="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.css'))?>" />

<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">

<style>

</style>
<?php $this->stop() ?>

<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

<div class="row">
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Laporan Peminjaman Buku</h1>
		</div>

        <div class="card">
			<div class="card-header py-3">
				<div class="row">
					<div class="col-12">
						<form name="form-search-name">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-2">
									<input class="rounded-lg w-100"  style="border-color: rgba(0, 0, 255, 0.3); height: calc(1.5em + 0.5rem + 2px); font-size: 12px; color: currentcolor; padding-left: inherit;" type="text" name="daterange" 
									/>
								</div>

								<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-2">
									<select class="form-control form-control-sm" name="status" id="status">
										<option value="">Status - Semua</option>
										<option value="sudah">Sudah Mengembalikan</option>
										<option value="belum">Belum Mengembalikan</option>
									</select>
								</div>
								
								<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
									<input type="text" class="form-control form-control-sm" name="s_member_name" placeholder="Nama Member">
								</div>

								<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
									<input type="text" class="form-control form-control-sm" name="s_book_name" placeholder="Nama Buku">
								</div>

								<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1">
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
				<div class="row">
					<div class="col-12">

						<div class="btn-group btn-group-sm">
							<button id="btn-download-excel" type="button" class="btn btn-sm btn-success">
								<i class="fas fa-file-excel"></i>
								<span class="ml-1">Download Excel</span>
							</button>
							<button id="btn-download-pdf" type="button" class="btn btn-sm btn-danger" >
								<i class="fas fa-file-pdf"></i>
								<span class="ml-1">Download PDF</span>
							</button>
						</div>

					</div>
				</div>
                <div class="table-reponsive" style="overflow: auto;">
					<table id="table-main" class="table table-sm table-striped w-100">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Peminjam</th>
                                <th>Nama Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jumlah Hari</th>
                                <th>Batas Waktu Pengembalian</th>
                                <th>Terlambat</th>
                                <th>Denda</th>
                                <th>Terbayar</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
				<div class="d-flex flex-nowrap w-100 mt-3">
					<small>Download maskimal hanya <span class="text-danger">30.000</span> baris</small>
				</div>
            </div>
        </div>

    </div>
</div>


<?php $this->stop() ?>

<!-- SECTION JS -->
<?php $this->start('js') ?>
<script type="text/javascript" src="<?=$this->e(base_url('assets/node_modules/moment/min/moment.min.js'))?>"></script>
<script type="text/javascript" src="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/js/pages/orderReport.js'))?>"></script>
<!-- <script src="<?//=base_url('assets/js/jquery.redirect.js')?>"></script> -->

<script>

	$('input[name="daterange"]').val(moment().startOf('month').format('L') + ' - ' + moment().endOf('month').format('L'));	

</script>

<?php $this->stop() ?>
