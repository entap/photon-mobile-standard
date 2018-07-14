<?php

require_once __DIR__ . '/../../system/photon/photon.php';
require_once __DIR__ . '/../../system/api/api.php';

/**
 * デバイスを追加する
 */
function action_index($data)
{
	api_begin($data, API_IGNORE_D);

	//------------------------------------------------------------------------------

	// 形式チェック
	if (!(isset($data['resolution_width']) && is_numeric($data['resolution_width']))) {
		api_die('Invalid resolution_width');
	}
	if (!(isset($data['resolution_height']) && is_numeric($data['resolution_height']))) {
		api_die('Invalid resolution_height');
	}
	if (!(isset($data['device_info']) && is_array($data['device_info']))) {
		api_die('Invalid device_info');
	}

	//------------------------------------------------------------------------------

	// デバイス識別子を生成する
	$d = 'd_' . bin2hex(openssl_random_pseudo_bytes(16));

	// デバイスを登録する
	$device_id = db_insert('device', [
		'd' => $d,
		'platform_id' => $data['platform_id'],
		'resolution_width' => $data['resolution_width'],
		'resolution_height' => $data['resolution_height'],
	]);

	// デバイス情報を登録する
	db_insert('device_info', $data['device_info'], $device_id);

	//------------------------------------------------------------------------------

	api_end(['d' => $d]);
}

execute();
?>