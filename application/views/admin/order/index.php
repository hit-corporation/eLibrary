<?php $this->layout('layouts::admin_template', ['title' => 'Book Order'])?>


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

<div class="container-fluid">
    <div class="row">
        <form name="form-input" method="POST" action="<?=$this->e(base_url('order/store'))?>" class="col-12">
			
            <div class="d-sm-flex align-items-center justify-content-between mb-4 px-2 w-100">
                <h1 class="h3 mb-0 text-gray-800"><?=$this->e('Formulir Peminjaman Buku')?></h1>
               
            </div>
            <!-- START TRANSACTION CARD-->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detail Transaksi</h4>
                </div>
                <div class="card-body">
                   
                    <fieldset class="form-row">
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label mb-0">Kode Transaksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="code" value="<?=$_SESSION['error']['old']['code'] ?? strtoupper(bin2hex(random_bytes(8))) ?? NULL ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label mb-0">Pindai Kartu Anggota<span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['card_no'])): ?> is-invalid <?php endif ?>" name="card_no" value="<?=$_SESSION['error']['old']['card_no'] ??  NULL ?>" autofocus="on" autocomplete="off">
                            <?php if(!empty($_SESSION['error']['errors']['card_no'])): ?>
                                <small class="text-danger"><?=$_SESSION['error']['errors']['card_no']?></small>
                            <?php endif ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label mb-0">Nama Anggota<span class="text-danger">*</span></label>
                            <select class="form-control <?php if(!empty($_SESSION['error']['errors']['member'])): ?> is-invalid <?php endif ?>" name="member" value="<?=$_SESSION['error']['old']['member'] ?? NULL ?>"></select>
                            <?php if(!empty($_SESSION['error']['errors']['member'])): ?>
                                <small class="text-danger"><?=$_SESSION['error']['errors']['member']?></small>
                            <?php endif ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label mb-0">Tanggal Peminjaman <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start-date" value="<?=$_SESSION['error']['old']['start-date'] ?? NULL ?>">
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label mb-0">Tanggal Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end-date" value="<?=$_SESSION['error']['old']['end-date'] ?? NULL ?>">
                        </div>
                        
                    </fieldset>
                </div>
            </div>
            <!-- END TRANSACTION CARD -->
            <div class="form-row mt-4">

                <!-- START BOOK FIELD-->
                <fieldset class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-nowrap">
                            <h4 class="mb-0">Buku</h4>
                            <button type="button" id="btn-add-book" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-auto">
                                <i class="fas fa-plus fa-sm text-white-50"></i> 
                                Tambah Buku
                            </button>
                        </div>
                        <div class="card-body pt-0 px-0">
                            <table id="book-form" class="table table-sm w-100">
                                <thead class="bg-primary text-white d-none d-lg-table-head">
                                    <tr>
                                        <th class="pl-2" style="width: 20%">Kode Stock <span class="text-danger">*</span></th>
                                        <th class="pl-2" style="width: 50%">Judul <span class="text-danger">*</span></th>
                                        <th class="pl-2">Tgl Kembali <span class="text-danger">*</span></th>
                                        <th class="pl-2">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="d-flex flex-column d-lg-table-row">
                                        <td class="d-inline-block d-lg-table-cell" style="width: 20% !importants">
                                            <label class="d-lg-none mb-0">Kode Stok</label>
                                            <input type="text" class="form-control book-code" name="book[0][book_code]"  value="<?=$_SESSION['error']['old']['book'][0]['book_code'] ?? NULL ?>" autocomplete="off" autofocus>
                                            <?php if(!empty($_SESSION['error']['errors']['book[0][book_code]'])): ?>
                                                <small class="text-danger"><?=$_SESSION['error']['errors']['book[0][book_code]']?></small>
                                            <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                            <label class="d-lg-none mb-0">Judul</label>
                                            <select class="form-control <?php if(!empty($_SESSION['error']['errors']['book[0][title]'])):?> is-invalid <?php endif ?>" name="book[0][title]" value="<?=$_SESSION['error']['old']['book'][0]['title'] ?? NULL ?>"></select>
                                            <?php if(!empty($_SESSION['error']['errors']['book[0][title]'])): ?>
                                                <small class="text-danger"><?=$_SESSION['error']['errors']['book[0][title]']?></small>
                                            <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                            <label class="d-lg-none mb-0">Tgl Pengembalian</label>
                                            <input type="date" class="form-control <?php if(!empty($_SESSION['error']['errors']['book[0][return_date]'])): ?> is-invalid <?php endif ?>" name="book[0][return_date]" value="<?=$_SESSION['error']['old']['book'][0]['return_date'] ?? NULL ?>">
                                            <?php if(!empty($_SESSION['error']['errors']['book[0][return_date]'])): ?>
                                                <small class="text-danger"><?=$_SESSION['error']['errors']['book[0][return_date]']?></small>
                                            <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                        </td>
                                    </tr>
                                    <!-- more errors -->
                                    <?php 
                                        if(isset($_SESSION['error']['old']['book']) && count($_SESSION['error']['old']['book']) > 1): 
                                            foreach($_SESSION['error']['old']['book'] as $key => $value):
                                                if($key === 0) continue;
                                    ?>
                                    <tr class="d-flex flex-column d-lg-table-row">
                                        <td class="d-inline-block d-lg-table-cell" style="width: 20% !important">
                                            <label class="d-lg-none mb-0">Kode Stok</label>
                                            <input type="text" class="form-control <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][book_code]'])): ?> is-invalid <?php endif ?>" 
                                                name="book[<?=$key?>][book_code]" value="<?=$_SESSION['error']['old']['book'][$key]['book_code'] ?? NULL?>" autocomplete="off" autofocus>
                                                <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][book_code]'])): ?> 
                                                    <small class="text-danger"><?=$_SESSION['error']['errors']['book['.$key.'][book_code]']?></small>
                                                <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                            <label class="d-lg-none mb-0">Judul</label>
                                            <select class="form-control book-title <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][title]'])):?> is-invalid <?php endif ?>" name="book[<?=$key?>][title]" value="<?=$_SESSION['error']['old']['book'][$key]['title'] ?? NULL ?>"></select>
                                            <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][title]'])): ?>
                                                <small class="text-danger"><?=$_SESSION['error']['errors']['book['.$key.'][title]']?></small>
                                            <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                            <label class="d-lg-none mb-0">Tgl Pengembalian</label>
                                            <input type="date" class="form-control <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][return_date]'])): ?> is-invalid <?php endif ?>" name="book[<?=$key?>][return_date]" value="<?=$_SESSION['error']['old']['book'][$key]['return_date'] ?? NULL ?>">
                                            <?php if(!empty($_SESSION['error']['errors']['book['.$key.'][return_date]'])): ?>
                                                <small class="text-danger"><?=$_SESSION['error']['errors']['book['.$key.'][return_date]']?></small>
                                            <?php endif ?>
                                        </td>
                                        <td class="d-inline-block d-lg-table-cell">
                                            <button class="btn-circle btn-danger rounded-circle border-0 delete_data" type="button" onclick="deleteRow(event)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php 
                                            endforeach;
                                        endif; 
                                    ?>
                                    <!-- end more errors -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                   
                </fieldset>
                <!-- END BOOK FIELDS -->
                <span class="ml-auto d-flex flex-nowrap justify-content-end mt-3">
                        <button type="reset" class="btn btn-secondary"><i class="fas fa-sync"></i> Ulangi</button>
                        <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i> Simpan</button>
                    </span>
            </div>
        </form>
    </div>
</div>



<?php $this->stop() ?>

<!-- JS SECTION -->
<?php $this->start('js') ?>
<script src="<?=$this->e(base_url('assets/node_modules/@selectize/selectize/dist/js/selectize.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/bootstrap-4-autocomplete/dist/bootstrap-4-autocomplete.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>

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

<script src="<?=$this->e(base_url('assets/js/pages/bookOrder.js'))?>"></script>

<?php $this->stop() ?>
