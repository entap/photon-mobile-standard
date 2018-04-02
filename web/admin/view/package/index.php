<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="row">
	<div class="col-xs-3"><?php include __DIR__ . '/../common/sidebar_package.php' ?></div>
	<div class="col-xs-9">
		<div class="page-header">
			<h1>パッケージ</h1>
		</div>
		<p class="text-right">
			<a href="package.php?action=edit" class="btn btn-primary" data-toggle="remote-modal"><span class="glyphicon glyphicon-plus"></span> パッケージを構築</a>
		</p>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th class="col-xs-2">バージョン</th>
				<th class="col-xs-3">対応アプリ</th>
				<th class="col-xs-4">配信状態</th>
				<th class="col-xs-3">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($data['records'] as $record) { ?>
				<tr>
					<td><?= h(version_int2str($record['package_version'])) ?></td>
					<td><?= h(version_int2str($record['app_version_min'])) ?>-<?= h(version_int2str($record['app_version_max'])) ?></td>
					<td><?= package_status_display($record) ?></td>
					<td>
						<div class="text-center">
							<a href="package.php?action=edit&id=<?= $record['id'] ?>" class="btn btn-primary btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-edit"></span> 編集</a>
							<a href="package.php?action=delete&id=<?= $record['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？');"><span class="glyphicon glyphicon-trash"></span> 削除</a>
						</div>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?= $data['html'] ?>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
