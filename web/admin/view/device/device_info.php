<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">デバイス情報</h4>
		</div>
		<div class="modal-body">
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
			<?= $data['html'] ?>
		</div>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
