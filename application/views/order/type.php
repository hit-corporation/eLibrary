<?php $this->layout('layouts::main_template', ['title' => 'Book Order'])?>

<!-- CSS SECTION -->
<?php $this->start('css') ?>
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/@selectize/selectize/dist/css/selectize.bootstrap4.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">
<link rel="stylesheet" href="<?=$this->e(base_url('assets/css/main.min.css'))?>">

<style>

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
        <div class="col-12">

            <div class="d-sm-flex align-items-center justify-content-between mb-4 px-2">
                <h1 class="h3 mb-0 text-gray-800"><?=$this->e('Formulir Peminjaman Buku')?></h1>
            </div>

            <div class="card">
                <form class="card-body">
                    <fieldset class="form-row">
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label">Anggota</label>
                            <select class="form-control" name="member"></select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" name="start-date">
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                            <label for="" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="end-date" value="">
                        </div>
                    </fieldset>
                   <fieldset class="w-100 mt-4 ">
                        <div class="d-flex flex-nowrap w-100">
                            <h4>Buku</h4>
                            <button type="button" id="btn-add-book" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-auto">
                                <i class="fas fa-plus fa-sm text-white-50"></i> 
                                Tambah
                            </button>
                        </div>
                        <table id="book-form" class="table table-sm w-100">
                            <thead class="bg-primary text-white d-none d-lg-table-head">
                                <tr>
                                    <th style="width: 40%">Judul</th>
                                    <th>Jumlah</th>
                                    <th>Tgl Kembali</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="d-flex flex-column d-lg-table-row">
                                    <td class="d-inline-block d-lg-table-cell">
                                        <label class="d-lg-none mb-0">Judul</label>
                                        <select class="form-control" name="book[0][title]"></select>
                                    </td>
                                    <td class="d-inline-block d-lg-table-cell">
                                        <label class="d-lg-none mb-0">Jumlah</label>
                                        <input type="number" min="0" class="form-control" name="book[0][qty]">
                                    </td>
                                    <td class="d-inline-block d-lg-table-cell">
                                        <label class="d-lg-none mb-0">Tgl Pengembalian</label>
                                        <input type="date" class="form-control" name="book[0][return_date]">
                                    </td>
                                    <td class="d-inline-block d-lg-table-cell">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                   </fieldset>
                   <fieldset class="row justify-content-right">
                        <button ty></button>
                   </fieldset>
                </form>
            </div>

        </div>
    </div>
</div>



<?php $this->stop() ?>

<!-- JS SECTION -->
<?php $this->start('js') ?>
<script src="<?=$this->e(base_url('assets/node_modules/@selectize/selectize/dist/js/selectize.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>
<script src="<?=$this->e(base_url('assets/js/pages/bookOrder.js'))?>"></script>

<?php $this->stop() ?>