<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/common.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/device.php';

/**
 * 端末の一覧
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
 * 端末の表示
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
 * 端末の割当履歴
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
 * 端末情報
 */
function action_device_info($data)
{
	$data['id'] = intval($data['id']);
	$data['id'] or die;
	$data['device'] = db_select_at('device', $data['id']);
	$data['device_info'] = db_select_at('device_info', $data['id']);
	$data['field_comments'] = field_comments('device_info');
	render('view/device/device_info.php', $data);
}

/**
 * 開発端末
 */
function action_device_test($data)
{
	$data['id'] = isset($data['id']) ? intval($data['id']) : 0;
	if (is_request_post()) {
		rule_clean();
		rule('device_test[device_id]');
		rule('device_test[test_name]', ['required' => 'yes', 'max_chars' => 20]);
		$data = filter($data);
		if (validate($data)) {
			db_replace('device_test', $data['device_test']);
			return redirect('device.php');
		}
	} else if ($data['id']) {
		$data['device_test'] = db_select_at('device_test', $data['id']);
		$data['device_test']['device_id'] = $data['id'];
	} else {
		die;
	}
	form_set_value(NULL, $data);
	render('view/device/device_test.php', $data);
}

/**
 * 開発端末の削除
 */
function action_device_test_delete($data)
{
	db_delete_at('device_test', $data['id'], 'device_id');
	redirect('device.php');
}

admin_bootstrap(TRUE);
admin_has_role('device') or die;
execute();
?>