<?php require_once __DIR__ . '/../common/header.php' ?>
<div class="row">
	<div class="col-xs-3"><?php include __DIR__ . '/../common/sidebar_package.php' ?></div>
	<div class="col-xs-9">
		<div class="page-header">
			<h1>エクスポートするテーブル</h1>
		</div>
		<form action="package_table.php" method="post" class="form-inline">
			<p class="text-right">
				<?= form_select_assoc('package_table[name]', package_table_get_options(), 'class="form-control"') ?>
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> テーブルを追加
				</button>
			</p>
		</form>
		<ul class="list-group">
			<?php foreach ($data['records'] as $record) { ?>
				<li class="list-group-item">
					<div class="pull-right"><a href="package_table.php?action=delete&id=<?= $record['id'] ?>"><span class="glyphicon glyphicon-remove"></span> エクスポート対象から外す</a></div>
					<div><?= h($record['name']) ?></div>
				</li>
			<?php } ?>
		</ul>
		<?= $data['html'] ?>
	</div>
</div>
<?php require_once __DIR__ . '/../common/footer.php' ?>
