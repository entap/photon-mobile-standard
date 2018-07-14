<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="page-header">
	<h1>端末</h1>
</div>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="col-xs-4">識別子</th>
		<th class="col-xs-1">OS</th>
		<th class="col-xs-2">デバイス名</th>
		<th class="col-xs-5">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data['records'] as $record) { ?>
		<tr>
			<td><?= h($record['d']) ?></td>
			<td><?= h($record['platform_name']) ?></td>
			<td><?= h($record['device_name']) ?></td>
			<td>
				<div class="text-center">
					<a href="user.php?action=view&id=<?= $record['user_id'] ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-user"></span> ユーザ</a>
					<a href="device.php?action=device_user&id=<?= $record['id'] ?>" class="btn btn-info btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-th-list"></span> ユーザ履歴</a>
					<a href="device.php?action=device_info&id=<?= $record['id'] ?>" class="btn btn-info btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-phone"></span> 端末情報</a>
					<a href="device.php?action=device_test&id=<?= $record['id'] ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-wrench"></span> 開発端末</a>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?= $data['html'] ?>
<?php require_once __DIR__ . '/../common/footer.php' ?>
