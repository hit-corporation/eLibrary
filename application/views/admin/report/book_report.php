<?php $this->layout('layouts::admin_template', ['title' => 'Kategori'])?>

<!-- SECTION CSS -->
<?php $this->start('css') ?>

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
			<h1 class="h3 mb-0 text-gray-800">Laporan Buku</h1>
		</div>

        <div class="card">
			<div class="card-header py-3">
				<div class="row">
				
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<form name="form-search-name">
							<div class="row">
								<div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-xs-6 mb-1">
									<select class="form-control form-control-sm" name="stok" id="stok">
										<option value="">Stok - Semua</option>
										<option value="unavailable">Habis</option>
										<option value="available">Tersedia</option>
									</select>
								</div>
								
								<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
									<input type="text" class="form-control form-control-sm" name="s_author_name" placeholder="Nama Penulis">
								</div>
								
								<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
									<input type="text" class="form-control form-control-sm" name="s_publisher_name" placeholder="Nama Penerbit">
								</div>

								<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
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

				</div>
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
                                <th>Gambar</th>
                                <th>Nama</th>
								<th>Stok</th>
								<th>Stok Dipinjam</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>isbn</th>
                                <th>Year</th>
                                <th>Kategori</th>
                                <th>Tanggal Input</th>
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

	<script src="<?=$this->e(base_url('assets/js/pages/bookReports.js'))?>"></script>

<?php $this->stop() ?>
