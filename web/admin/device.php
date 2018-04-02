<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/device.php';

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

admin_bootstrap(TRUE);
admin_has_role('device') or die;
execute();
?>