<?php $this->layout('admin/setting::index', ['title' => 'Pengaturan']) ?>


<?php $this->start('setting_pages') ?>

<div class="row justify-content-center mt-5">
    <div class="col-12 col-md-8 col-lg-6 pt-5">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white font-weight-bold text-shadow mb-0">Jatuh Tempo Pengembalian</h4>
            </div>
            <form name="form-input" class="card-body" method="POST">
                <?= validation_errors() ?>
                <div class="form-row mb-5">
                    <div class="col-4">
                        <label class="form-label mb-0">Nilai <span class="text-danger">*</span></label>
                        <select name="nilai" class="form-control <?=empty($_SESSION['error']['errors']['nilai']) ?: 'is-invalid' ?>">
                            <?php for($i=1;$i<=100;$i++): ?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor ?>
                        </select>
                        <?php if(!empty($_SESSION['error']['errors']['nilai'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['nilai']?></small>
                        <?php endif ?>
                    </div>
                    <div class="col-1 d-flex flex-nowrap justify-content-center align-items-center"><span class="mt-4">-</span></div>
                    <div class="col-7">
                        <label class="form-label mb-0">Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-control <?=empty($_SESSION['error']['errors']['unit']) ?: 'is-invalid' ?>">
                            <option value="days">Hari</option>
                            <option value="weeks">Minggu</option>
                            <option value="months">Bulan</option>
                        </select>
                        <?php if(!empty($_SESSION['error']['errors']['unit'])): ?>
                            <small class="text-danger"><?=$_SESSION['error']['errors']['unit']?></small>
                        <?php endif ?>
                    </div>
                </div>
                <hr class="mt-3">    
                <div class="form-row w-100 justify-content-end">
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

<?php if(isset($_SESSION['success'])): ?>

    Swal.fire({
        icon: 'success',
        title: '<h4 class="text-success">SUKSES</h4>',
        html: '<h5 class="text-success"><?=$_SESSION['success']['message']?></h5>',
        timer: 1500
    });

<?php endif ?>

(async $ => {

    form['nilai'].value = `<?=$_SESSION['error']['old']['nilai'] ?? $due_date['nilai'] ?>`;
    form['unit'].value = `<?=$_SESSION['error']['old']['unit'] ?? $due_date['unit'] ?>`;

})(jQuery)

</script>
<?php $this->stop() ?>
