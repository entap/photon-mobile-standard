<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">端末情報</h4>
		</div>
		<div class="modal-body">
			<?php if ($device_info === NULL) { ?>
				<p class="alert alert-danger">端末情報が登録されていません。</p>
			<?php } else { ?>
				<p>解像度</p>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th class="col-xs-3">幅</th>
						<td><?= h($device['resolution_width']) ?></td>
					</tr>
					<tr>
						<th>高さ</th>
						<td><?= h($device['resolution_height']) ?></td>
					</tr>
					</tbody>
				</table>
				<p>端末情報</p>
				<table class="table table-bordered">
					<tbody>
					<?php foreach ($device_info as $key => $value) { ?>
						<tr>
							<th class="col-xs-3">
								<small><?= h($field_comments[$key]) ?></small>
							</th>
						</tr>
						<tr>
							<td class="col-xs-9">
								<small><?= h($value) ?></small>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
