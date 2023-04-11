<?php $this->layout('layouts::admin_template', ['title' => 'Pengaturan']) ?>

<?php $this->start('css') ?>
<link rel="stylesheet" href="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'))?>">

<style>
    .vh-75 {
        height: 75vh;
    }
</style>
<?=$this->section('child_css')?>
<?php $this->stop() ?>

<?php $this->start('contents') ?>

<div class="container-fluid vh-75">
    <nav class="btn-group btn-group-sm">
        <a class="btn btn-sm btn-purple" href="<?=base_url('setting/loan')?>"><i class="fas fa-calendar-times"></i> Peminjaman</a>
        <a class="btn btn-sm btn-purple" href="<?=base_url('fines')?>"><i class="fas fa-coins"></i> Denda</a>
    </nav>
    <?=$this->section('setting_pages')?>
</div>

<?php $this->stop() ?>

<?php $this->start('js') ?>
<script src="<?=$this->e(base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'))?>"></script>


<?=$this->section('child_js')?>
<?php $this->stop() ?>
