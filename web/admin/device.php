<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/common.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/device.php';

// デバイス情報のフィールド名を取得
function _device_info_fields($table)
{
	return db_select_column('SHOW FULL COLUMNS FROM ' . db_quote_field($table), 'Comment', 'Field');
}

/**
 * デバイスの一覧
 */
function action_index($data)
{
	if (!isset($data['c'])) {
		$data['c'] = [];
	}
	$data['data'] = db_paginate(device_sql($data['c']));
	form_set_value('c', $data['c']);
	render('view/device/index.php', $data);
}

/**
 * デバイスの表示
 */
function action_view($data)
{
	$data['id'] = intval($data['id']);
	$data['id'] or die;
	if ($data['id']) {
		$data['device'] = device_get($data['id']);
		$data['device'] or die;
	}
	form_set_value(NULL, $data);
	render('view/device/view.php', $data);
}

/**
 * デバイスの割当履歴
 */
function action_device_user($data)
{
	$data['id'] = intval($data['id']);
	$data['id'] or die;

	sql_clean();
	sql_table('log_device_user');
	sql_field('user.*');
	sql_join('user', 'id', 'log_device_user', 'user_id');
	$data['data'] = db_paginate(sql_select());

	render('view/device/device_user.php', $data);
}

/**
 * デバイスの情報
 */
function action_device_info($data)
{
	$data['id'] = intval($data['id']);
	$data['id'] or die;
	$data['device_info'] = db_select_at('device_info', $data['id']);
	$data['field_comments'] = field_comments('device_info');
	render('view/device/device_info.php', $data);
}

admin_bootstrap(TRUE);
admin_has_role('device') or die;
execute();
?>