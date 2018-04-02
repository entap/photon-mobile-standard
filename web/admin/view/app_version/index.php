<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="row">
	<div class="col-xs-3"><?php include __DIR__ . '/../common/sidebar_package.php' ?></div>
	<div class="col-xs-9">
		<div class="page-header">
			<h1><?= $platform['name'] ?>アプリのバージョン</h1>
		</div>
		<p class="text-right">
			<a href="app_version.php?action=edit&app_version[platform_id]=<?= $platform['id'] ?>" class="btn btn-primary" data-toggle="remote-modal"><span class="glyphicon glyphicon-plus"></span> <?= $platform['name'] ?>アプリのバージョンを登録</a>
		</p>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th class="col-xs-2">バージョン</th>
				<th class="col-xs-3">最新パッケージ</th>
				<th class="col-xs-4">配信状態</th>
				<th class="col-xs-3">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($data['records'] as $record) { ?>
				<tr>
					<td><?= h(version_int2str($record['app_version'])) ?></td>
					<td><?= h($record['package_version'] ? version_int2str($record['package_version']) : 'なし') ?></td>
					<td><?= h($record['expired_flag'] ? '期限切れ' : '配信中') ?></td>
					<td>
						<div class="text-center">
							<a href="app_version.php?action=edit&id=<?= $record['id'] ?>" class="btn btn-primary btn-sm" data-toggle="remote-modal"><span class="glyphicon glyphicon-edit"></span> 編集</a>
							<a href="app_version.php?action=delete&id=<?= $record['id'] ?>&platform_id=<?= $record['platform_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？');"><span class="glyphicon glyphicon-trash"></span> 削除</a>
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
