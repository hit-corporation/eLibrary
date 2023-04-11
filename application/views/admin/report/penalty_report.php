<?php $this->layout('layouts::admin_template', ['title' => 'Kategori'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>

<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.css'))?>" />

<style>
	.input-date-range {
		border-color: rgba(0, 0, 255, 0.3);
		height: calc(1.5em + 0.5rem + 2px);
		font-size: 12px;
		color: currentcolor;
		padding-left: inherit;
	}
</style>
<?php $this->stop() ?>

<!-- SECTION CONTENT -->
<?php $this->start('contents') ?>

<div class="row">
	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Laporan Denda Berjalan</h1>
		</div>

        <div class="card">
			<div class="card-header py-3">
				
				<form name="form-search">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-1">
							<input class="rounded-lg w-100 input-date-range" type="text" name="daterange" />
						</div>

						

						<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-1">
							<input type="text" class="form-control form-control-sm" name="s_book_name" placeholder="Nama Buku">
						</div>

						<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-1">
							<input type="text" class="form-control form-control-sm" name="s_member_name" placeholder="Nama Member">
						</div>

						<div class="">
							<div class="btn-group btn-group-sm col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xl-2">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
								<button type="reset" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
							</div>
						</div>
					</div>
				</form>

			</div>

            <div class="card-body">
				<!-- Download Buttons: @created_by Naquib-->
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
				<!-- End Donload Button-->
                <div class="table-reponsive" style="overflow: auto;">
					<table id="table-main" class="table table-sm table-striped w-100">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Nama Peminjam</th>
                                <th>Nama Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jumlah Hari</th>
                                <th>Batas Waktu Pengembalian</th>
                                <th>Terlambat</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>



<?php $this->stop() ?>

<!-- SECTION JS -->
<?php $this->start('js') ?>

<script src="<?=$this->e(base_url('assets/node_modules/daterangepicker/moment.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.js'))?>"></script>

<script src="<?= $this->e(base_url('assets/js/pages/penaltyReport.js'))?>"></script>

<?php $this->stop() ?>
