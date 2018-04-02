<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/package_table.php';

/**
 * パッケージのテーブルの一覧
 */
function action_index($data)
{
	if (is_request_post()) {
		$data = package_table_validate($data, 'edit');
		if (!form_has_error()) {
			package_table_save($data['package_table']);
		}
	}
	if (!isset($data['c'])) {
		$data['c'] = [];
	}
	$data['data'] = db_paginate(package_table_sql($data['c']));
	form_set_value('c', $data['c']);
	render('view/package_table/index.php', $data);
}

/**
 * パッケージのテーブルの削除
 */
function action_delete($data)
{
	package_table_delete($data['id']);
	redirect('package_table.php');
}

admin_bootstrap(TRUE);
admin_has_role('package_table') or die;
execute();
?>