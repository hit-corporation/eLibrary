<?php $this->layout('admin/setting::index', ['title' => 'Pengaturan']) ?>


<?php $this->start('setting_pages') ?>

<div class="row justify-content-center pt-3">
    <div class="col-12 col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white font-weight-bold text-shadow mb-0">Peminjaman</h4>
            </div>
            <form name="form-input" method="POST" action="<?=$this->e(base_url('setting/store_loan'))?>" class="card-body">
                <div class="form-row align-items-center">
                    <label class="form-label col-12 col-md-4 col-lg-3">Maksimal Buku</label>
                    <div class="col-12 col-md-8 col-lg-9">
                        <input type="number" class="form-control" min="1" max="100" name="max_loan" value="2">
                    </div>
                </div>
                <div class="form-row align-items-center mt-3">
                    <label class="form-label col-12 col-md-4 col-lg-3">Durasi Peminjaman</label>
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="form-row">
                            <div class="col-4">
                                <select name="due_date[value]" class="form-control <?=empty($_SESSION['error']['errors']['due_date[value]']) ?: 'is-invalid' ?>">
                                    <?php for($i=1;$i<=100;$i++): ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php endfor ?>
                                </select>
                                <?php if(!empty($_SESSION['error']['errors']['due_date[value]'])): ?>
                                    <small class="text-danger"><?=$_SESSION['error']['errors']['due_date[value]']?></small>
                                <?php endif ?>
                            </div>
                            <div class="col-1 d-flex flex-nowrap justify-content-center align-items-center"><span>-</span></div>
                            <div class="col-7">
                                <select name="due_date[unit]" class="form-control <?=empty($_SESSION['error']['errors']['due_date[unit]']) ?: 'is-invalid' ?>">
                                    <option value="hours" selected>Jam</option>
                                    <option value="months">Bulan</option>
                                    <option value="days">Hari</option>
                                    <option value="weeks">Minggu</option>
                                    <option value="months">Bulan</option>
                                </select>
                                <?php if(!empty($_SESSION['error']['errors']['due_date[unit]'])): ?>
                                    <small class="text-danger"><?=$_SESSION['error']['errors']['due_date[unit]']?></small>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row align-items-center mt-3">
                    <label class="form-label col-12 col-md-4 col-lg-3">Durasi ketika menganggur</label>
                    <div class="col-12 col-md-8 col-lg-8">
                        
                    </div>
                </div>
                <hr class="mt-5">
                <div class="d-flex flex-nowrap w-100 justify-content-end">
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-sync"></i> Ulangi</button>
                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>            
        </div>
    </div>
</div>
<?php $this->stop() ?>

<?php $this->start('child_js') ?>

<script>
'use strict';
const form = document.forms['form-input'];

<?php if(!empty($_SESSION['error']['message'])): ?>

    Swal.fire({
        icon: 'error',
        title: '<h4 class="text-danger">GAGAL</h4>',
        html: '<h5 class="text-danger"><?=$_SESSION['error']['message']?></h5>',
        timer: 1500
    });

<?php endif ?>

<?php if(!empty($_SESSION['success']['message'])): ?>

    Swal.fire({
        icon: 'success',
        title: '<h4 class="text-success">SUKSES</h4>',
        html: '<h5 class="text-success"><?=$_SESSION['success']['message']?></h5>',
        timer: 1500
    });

<?php endif ?>

(async $ => {

    form['due_date[value]'].value = `<?=$_SESSION['error']['old']['due_date[value]'] ?? $settings['due_date_value'] ?>`;
    form['due_date[unit]'].value = `<?=$_SESSION['error']['old']['due_date[unit]'] ?? $settings['due_date_unit'] ?>`;
    form['max_loan'].value = `<?=$_SESSION['error']['old']['max_loan'] ?? $settings['max_allowed'] ?>`;

	form.addEventListener('submit', e => {
		loading();
	});

})(jQuery)

const loading = () => {
    Swal.fire({
        html: 	'<div class="d-flex flex-column align-items-center">'
        + '<span class="spinner-border text-primary"></span>'
        + '<h3 class="mt-2">Loading...</h3>'
        + '<div>',
        showConfirmButton: false,
        width: '10rem'
    });
}

</script>
<?php $this->stop() ?>
