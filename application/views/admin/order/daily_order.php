<?php $this->layout('layouts::admin_template', ['title' => 'Kategori'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>
	<link href="<?=$this->e(base_url('assets/vendor/jstree/dist/themes/default/style.min.css'))?>" rel="stylesheet">
	<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
	<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">
	<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.css'))?>" />
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
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Data Peminjaman buku harian</h1>
		</div>

        <div class="card">
			<div class="card-header py-3">
				<form name="form-search">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-2">
							<input class="rounded-lg w-100"  style="border-color: rgba(0, 0, 255, 0.3); height: calc(1.5em + 0.5rem + 2px); font-size: 12px; color: currentcolor; padding-left: inherit;" type="text" name="daterange"/>
						</div>

						<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-xs-12 mb-2">
							<select class="form-control form-control-sm" name="status" id="status">
								<option value="belum">Belum Mengembalikan</option>
								<option value="sudah">Sudah Mengembalikan</option>
								<option value="semua">Status - Semua</option>
							</select>
						</div>

						<div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-2">
							<input type="text" class="form-control form-control-sm" name="s_member_name" placeholder="Nama Member">
						</div>

						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-2">
							<input type="text" class="form-control form-control-sm" name="s_book_name" placeholder="Nama Buku">
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
                <div class="table-reponsive" style="overflow: auto;">
					<table id="table-main" class="table table-sm table-striped w-100" style="overflow-x: auto;">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Book ID</th>
                                <th>Nama Peminjam</th>
                                <th>Nama Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jumlah Hari</th>
                                <th>Batas Waktu Pengembalian</th>
                                <th>Terlambat</th>
                                <th>Denda</th>
                                <th>Terbayar</th>
                                <th>Tanggal Pengembalian</th>
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
	<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>
	<script src="<?=$this->e(base_url('assets/node_modules/daterangepicker/moment.min.js'))?>"></script>
	<script src="<?=$this->e(base_url('assets/node_modules/daterangepicker/daterangepicker.js'))?>"></script>
	<script src="<?=$this->e(base_url('assets/js/pages/dailyOrder.js'))?>"></script>


<?php $this->stop() ?>
