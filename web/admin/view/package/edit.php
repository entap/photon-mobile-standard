<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">パッケージ</h4>
		</div>
		<form action="package.php?action=edit" method="post" enctype="multipart/form-data">
			<?= form_hidden('package[id]') ?>
			<div class="modal-body">
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th class="col-xs-3">バージョン</th>
						<td class="form-inline">
							<?= form_error('package[package_version]') ?>
							<?= form_text('package[package_version]', 'class="form-control" size="10"') ?>
						</td>
					</tr>
					<tr>
						<th>対応アプリ</th>
						<td class="form-inline">
							<?= form_error('package[app_version_min]', 'package[app_version_max]') ?>
							<div>
								<?= form_text('package[app_version_min]', 'class="form-control" size="10"') ?>
								<span>から</span>
								<?= form_text('package[app_version_max]', 'class="form-control" size="10"') ?>
							</div>
						</td>
					</tr>
					<tr>
						<th>期限切れ</th>
						<td>
							<?= form_error('package[expired_flag]', 'package[expired_date_flag]', 'package[expired_date]') ?>
							<div class="checkbox"><?= form_checkbox('package[expired_flag]', '1', ' 期限切れ') ?></div>
							<div class="checkbox"><?= form_checkbox('package[expired_date_flag]', '1', ' 期限切れ日時を指定する') ?></div>
							<div class="form-inline"><?= form_date('package[expired_date]', '{y} 年 {m} 月 {d} 日 {h} 時', 'class="form-control"') ?></div>
						</td>
					</tr>
					<tr>
						<th>公開</th>
						<td>
							<?= form_error('package[public_flag]', 'package[public_date_flag]', 'package[public_date]') ?>
							<div class="checkbox"><?= form_checkbox('package[public_flag]', '1', ' 公開
							') ?></div>
							<div class="checkbox"><?= form_checkbox('package[public_date_flag]', '1', ' 公開開始日時を指定する') ?></div>
							<div class="form-inline"><?= form_date('package[public_date]', '{y} 年 {m} 月 {d} 日 {h} 時', 'class="form-control"') ?></div>
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
