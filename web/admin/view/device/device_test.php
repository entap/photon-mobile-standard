<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">開発端末</h4>
		</div>
		<form action="device.php?action=device_test" method="post" enctype="multipart/form-data">
			<?= form_hidden('device_test[device_id]') ?>
			<div class="modal-body">
				<label>開発端末の名前</label>
				<?= form_error('device_test[test_name]') ?>
				<?= form_text('device_test[test_name]', 'class="form-control"') ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> 保存</button>
				<a href="device.php?action=device_test_delete&id=<?= form_get_value('device_test[device_id]') ?>" class="btn btn-danger"><span class="glyphicon glyphicon-eject"></span> 開発端末解除</a>
			</div>
		</form>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
