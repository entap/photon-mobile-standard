<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/app_version.php';
require_once __DIR__ . '/../system/admin/package_latest.php';

/**
 * パッケージの一覧
 */
function action_index($data)
{
	if (!isset($data['c'])) {
		$data['c'] = [];
	}
	$data['platform'] = db_select_at('m_platform', $data['c']['platform_id']) or die;
	$data['data'] = db_paginate(app_version_sql($data['c']));
	form_set_value('c', $data['c']);
	render('view/app_version/index.php', $data);
}

/**
 * パッケージの編集
 */
function action_edit($data)
{
	$data['id'] = isset($data['id']) ? intval($data['id']) : 0;
	if (is_request_post()) {
		$data = app_version_validate($data, 'edit');
		if (!form_has_error()) {
			app_version_save($data['app_version']);
			package_latest_build();
			return redirect('app_version.php');
		}
	} else if ($data['id']) {
		$data['app_version'] = app_version_get($data['id']);
	} else {
		$data['app_version'] = [];
	}
	$data['platform'] = db_select_at('m_platform', $data['app_version']['platform_id']) or die;
	form_set_value(NULL, $data);
	render('view/app_version/edit.php', $data);
}

/**
 * パッケージの削除
 */
function action_delete($data)
{
	app_version_delete($data['id']);
	package_latest_build();
	redirect('app_version.php?c[platform_id]=' . $data['platform_id']);
}

admin_bootstrap(TRUE);
admin_has_role('app_version') or die;
execute();
?>