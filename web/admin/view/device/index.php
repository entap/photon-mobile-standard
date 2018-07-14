<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="page-header">
	<h1>デバイス</h1>
</div>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="col-xs-4">識別子</th>
		<th class="col-xs-2">開発端末</th>
		<th class="col-xs-1">OS</th>
		<th class="col-xs-2">デバイス名</th>
		<th class="col-xs-1">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data['records'] as $record) { ?>
		<tr>
			<td><?= h($record['d']) ?></td>
			<td><?= h($record['device_test_name']) ?></td>
			<td><?= h($record['platform_name']) ?></td>
			<td><?= h($record['device_name']) ?></td>
			<td>
				<div class="text-center">
					<a href="device.php?action=view&id=<?= $record['id'] ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> 詳細</a>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?= $data['html'] ?>
<?php require_once __DIR__ . '/../common/footer.php' ?>
