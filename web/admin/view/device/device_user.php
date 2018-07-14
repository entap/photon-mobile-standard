<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">ユーザ履歴</h4>
		</div>
		<div class="modal-body">
			<?php foreach ($data['records'] as $record) { ?>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<th class="col-xs-3">日時</th>
						<td><?= h($record['created']) ?></td>
					</tr>
					<tr>
						<th>識別子</th>
						<td><?= h($record['u']) ?></td>
					</tr>
					<tr>
						<th>ユーザ名</th>
						<td><?= h($record['name']) ?></td>
					</tr>
					</tbody>
				</table>
			<?php } ?>
			<?= $data['html'] ?>
		</div>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
