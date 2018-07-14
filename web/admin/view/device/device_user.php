<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">ユーザ履歴</h4>
		</div>
		<div class="modal-body">
			<table class="table table-bordered">
				<thead>
				<tr>
					<th class="col-xs-6">識別子</th>
					<th class="col-xs-5">名前</th>
					<th class="col-xs-1"></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($data['records'] as $record) { ?>
					<tr>
						<td><?= h($record['u']) ?></td>
						<td><?= h($record['name']) ?></td>
						<td>
							<a href="user.php?action=view&id=<?= h($record['id']) ?>" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-user"></span></a>
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
