<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="page-header">
	<h1>ユーザ</h1>
</div>
<p>
<form action="user.php" class="form-inline">
	<?= form_text('c[keywords]', 'class="form-control" size="38"') ?>
	<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検索</button>
</form>
</p>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="col-xs-5">ユーザ識別子</th>
		<th class="col-xs-5">PINコード</th>
		<th class="col-xs-2">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data['records'] as $record) { ?>
		<tr>
			<td><?= h($record['u']) ?></td>
			<td><?= h($record['pin']) ?></td>
			<td>
				<div class="text-center">
					<a href="user.php?action=view&id=<?= $record['id'] ?>&return=<?= urlencode(get_request_url()) ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> 詳細</a>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?= $data['html'] ?>
<?php require_once __DIR__ . '/../common/footer.php' ?>
