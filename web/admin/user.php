<?php

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/admin.php';
require_once __DIR__ . '/../system/admin/user.php';

/**
 * ユーザの一覧
 */
function action_index($data)
{
	if (!isset($data['c'])) {
		$data['c'] = [];
	}
	$data['data'] = db_paginate(user_sql($data['c']));
	form_set_value('c', $data['c']);
	render('view/user/index.php', $data);
}

/**
 * ユーザの表示
 */
function action_view($data)
{
	$data['id'] = intval($data['id']);
	$data['id'] or die;
	if ($data['id']) {
		$data['user'] = user_get($data['id']);
		$data['user'] or die;
	}
	form_set_value(NULL, $data);
	render('view/user/view.php', $data);
}

admin_bootstrap(TRUE);
admin_has_role('user') or die;
execute();
?>