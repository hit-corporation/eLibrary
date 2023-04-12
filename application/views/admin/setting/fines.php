<?php $this->layout('admin/setting::index', ['title' => 'Denda']) ?>

<?php $this->start('child_css') ?>
<?php $this->stop() ?>

<?php $this->start('setting_pages') ?>
<div class="container w-50 mt-5">
	<div class="card">
		<div class="card-header bg-orange">
			<h4 class="text-white mb-0">Denda</h4>
		</div>
		<form name="form-input" method="POST" action="<?=$this->e(base_url('fines/store'))?>" class="card-body">
			<div class="form-row align-items-center">
				<label class="form-label col-12 col-lg-4" for="amount">Nominal</label>
				<div class="col-12 col-lg-8">
					<input type="number" name="amount" id="amount" min="0" class="form-control" value="0"/>
				</div>
			</div>	
			<div class="form-row align-items-center mt-3 mb-3">
				<label class="form-label col-12 col-lg-4" for="amount">Periode</label>
				<div class="col-12 col-lg-8">
					<div class="d-flex flex-nowrap">
						<div class="col-3 p-0">
							<select name="period[value]" class="form-control <?=empty($_SESSION['error']['errors']['period[value]']) ?: 'is-invalid' ?>">
								<option value="0">--------------------</option>
								<?php for($i=1;$i<=100;$i++): ?>
								<option value="<?=$i?>"><?=$i?></option>
								<?php endfor ?>
							</select>
						</div>
						<div class="col-1 p-0 d-flex flex-nowrap justify-content-center align-items-center">
							<span>-</span>
						</div>
						<div class="col p-0">
							<select name="period[unit]" class="form-control <?=empty($_SESSION['error']['errors']['period[unit]']) ?: 'is-invalid' ?>">
								<option value="">--------------------</option>
								<option value="days">Hari</option>
								<option value="weeks">Minggu</option>
								<option value="months">Bulan</option>
							</select>
						</div>
					</div>
				</div>
			</div>	
			<div class="form-row">
				<label class="form-label col-4">Nilai Maksimal</label>
				<div class="col-8">
					<input type="number" name="max-amount" min="0" value="0" class="form-control">
				</div>
			</div>
			<hr class="mt-4 mb-3"/>
			<div class="row">
				<div class="col-12 d-flex flex-nowrap justify-content-end">
					<button type="submit" class="btn btn-purple ml-auto"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</div>
		</form>
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

	form.addEventListener('submit', e => {
		loading();
	});

	form['amount'].value = "<?=html_escape($_SESSION['error']['old']['amount'] ?? $settings['fines_amount']) ?>";
	form['period[value]'].value = "<?=html_escape($_SESSION['error']['old']['period[value]'] ?? $settings['fines_period_value']) ?>";
	form['period[unit]'].value = "<?=html_escape($_SESSION['error']['old']['period[unit]'] ?? $settings['fines_period_unit']) ?>";
	form['max-amount'].value = "<?=html_escape($_SESSION['error']['old']['max-amount'] ?? $settings['fines_maximum']) ?>";

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
