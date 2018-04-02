<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title"><?= $platform['name'] ?>アプリのバージョン</h4>
		</div>
		<form action="app_version.php?action=edit" method="post" enctype="multipart/form-data" class="form-inline">
			<?= form_hidden('app_version[id]') ?>
			<?= form_hidden('app_version[platform_id]') ?>
			<div class="modal-body">
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th class="col-xs-3">バージョン</th>
						<td>
							<?= form_error('app_version[app_version]') ?>
							<?= form_text('app_version[app_version]', 'class="form-control" size="10"') ?>
						</td>
					</tr>
					<tr>
						<th>期限切れ</th>
						<td>
							<?= form_error('app_version[expired_flag]') ?>
							<?= form_select_assoc('app_version[expired_flag]', 'boolean', 'class="form-control"') ?>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> 保存</button>
			</div>
		</form>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
