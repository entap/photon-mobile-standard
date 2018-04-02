<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="page-header">
	<h1>ユーザ</h1>
</div>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="col-xs-11">管理用の名前</th>
		<th class="col-xs-1">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data['records'] as $record) { ?>
		<tr>
			<td><?= h($record['name']) ?></td>
			<td>
				<div class="text-center">
					<a href="user.php?action=view&id=<?= $record['id'] ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> 詳細</a>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?= $data['html'] ?>
<?php require_once __DIR__ . '/../common/footer.php' ?>
