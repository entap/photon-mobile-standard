<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/package.php';
require_once __DIR__ . '/../system/admin/package_latest.php';

/**
 * パッケージの一覧
 */
function action_index($data)
{
	if (!isset($data['c'])) {
		$data['c'] = [];
	}
	$data['data'] = db_paginate(package_sql($data['c']));
	form_set_value('c', $data['c']);
	render('view/package/index.php', $data);
}

/**
 * パッケージの編集
 */
function action_edit($data)
{
	$data['id'] = isset($data['id']) ? intval($data['id']) : 0;
	if (is_request_post()) {
		$data = package_validate($data, 'edit');
		if (!form_has_error()) {
			package_save($data['package']);
			package_latest_build();
			return redirect('package.php');
		}
	} else if ($data['id']) {
		$data['package'] = package_get($data['id']);
	} else {
		$today = db_date();
		$data['package'] = [
			'expired_date'   => $today,
			'public_date' => $today,
		];
	}
	form_set_value(NULL, $data);
	render('view/package/edit.php', $data);
}

/**
 * パッケージの削除
 */
function action_delete($data)
{
	package_delete($data['id']);
	package_latest_build();
	redirect('package.php');
}

admin_bootstrap(TRUE);
admin_has_role('package') or die;
execute();
?>