<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="page-header">
	<h1>端末</h1>
	<small>登録済みのスマートフォン端末の情報</small>
</div>
<p>
<form action="device.php" class="form-inline">
	<?= form_text('c[keywords]', 'class="form-control" size="38"') ?>
	<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検索</button>
</form>
</p>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="col-xs-4">端末識別子</th>
		<th class="col-xs-1">OS</th>
		<th class="col-xs-3">デバイス名</th>
		<th class="col-xs-4">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data['records'] as $record) { ?>
		<tr>
			<td>
				<?= $record['device_test_id'] ? '<span class="label label-warning">開発</span>' : '' ?>
				<?= h($record['d']) ?>
			</td>
			<td><?= h($record['platform_name']) ?></td>
			<td><?= h($record['device_name']) ?></td>
			<td>
				<div class="text-center">
					<a href="user.php?action=view&id=<?= $record['user_id'] ?>&return=<?= urlencode(get_request_url()) ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-user"></span> ユーザ</a>
					<a href="device.php?action=device_info&id=<?= $record['id'] ?>" class="btn btn-default btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-phone"></span> 端末情報</a>
					<a href="device.php?action=device_test&id=<?= $record['id'] ?>" class="btn btn-default btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-wrench"></span> 開発端末</a>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?= $data['html'] ?>
<?php require_once __DIR__ . '/../common/footer.php' ?>
