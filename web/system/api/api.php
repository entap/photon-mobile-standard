<?php

/// 成功
define('API_STATUS_OK', 0);

/// 失敗
define('API_STATUS_ERROR', 1);

/// メンテナンス中
define('API_STATUS_MAINTENANCE', 2);

/// パッケージが古い
define('API_STATUS_EXPIRED_PACKAGE', 3);

/// アプリが古い
define('API_STATUS_EXPIRED_APP', 4);

/// デバイス識別子のチェックを行わない
define('API_IGNORE_D', 0x01);

/// ユーザのチェックを行わない
define('API_IGNORE_U', 0x02);

/**
 * APIの処理を開始する
 *
 * @param $param パラメータ
 * @param $options オプション
 */
function api_begin($param, $options = 0)
{
	global $__log_api_id;
	global $__device;

	// 形式チェック
	if (!(isset($param['platform_id']) && 1 <= $param['platform_id'] && $param['platform_id'] <= 3)) {
		api_die('Invalid platform_id');
	}
	if (!($options & API_IGNORE_D) && !(isset($param['d']) && strlen($param['d']) == 32)) {
		api_die('Invalid d');
	}

	// デバイスを取得
	if (!($options & API_IGNORE_D)) {
		sql_clean();
		sql_table('device');
		sql_field('device.*');
		sql_field('device_test.id IS NOT NULL', 'is_test');
		sql_join('device_test', 'device_id', 'device', 'id');
		sql_where_string('device.d', $param['d']);
		$__device = db_select_row(sql_select());
		if (!$__device) {
			api_die('Unknown device');
		}

		// ユーザIDをチェック
		if (!($options & API_IGNORE_U) && !$__device['user_id']) {
			api_die('Unregistered device');
		}
	}

	// 現在のアプリが古いか？
	if (!($options & API_IGNORE_D) && !$__device['is_test']) {
	}

	// ログに記録
	$__log_api_id = db_insert('log_api', [
		'd' => $param['d'],
		'platform_id' => $param['platform_id'],
		'app_version' => $param['app_version'],
		'pkg_version' => $param['pkg_version'],
		'name' => $_SERVER['SCRIPT_NAME'],
		'param' => json_encode($param, JSON_UNESCAPED_UNICODE),
		'ip_address' => $_SERVER['REMOTE_ADDR'],
	]);
}

/**
 * APIの結果を出力する
 *
 * @param $output 出力する配列
 */
function api_response($output)
{
	global $__log_api_id;

	// 出力
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($output);

	// ログに記録
	if (isset($__log_api_id)) {
		$output['response'] = json_encode($output['response']);
		db_update_at('log_api', $output, $__log_api_id);
	}
}

/**
 * APIの結果を成功として出力する
 *
 * @param $response レスポンス
 */
function api_end($response)
{
	api_response([
		'status' => API_STATUS_OK,
		'response' => $response,
	]);
}

/**
 * APIの結果を異常状態として出力する
 *
 * @param $message メッセージ
 * @param $status 結果
 */
function api_error($message = '', $status = API_STATUS_ERROR)
{
	api_response([
		'status' => $status,
		'message' => $message,
	]);
}

/**
 * APIの結果を異常状態として出力し、処理を中断する
 *
 * @param $message メッセージ
 * @param $status 結果
 */
function api_die($message = '', $status = API_STATUS_ERROR)
{
	api_error($message, $status);
	die();
}

/**
 * アクセス元のデバイスを取得する
 *
 * @return array アクセス元のデバイス情報
 */
function api_device()
{
	global $__device;
	return $__device;
}

/**
 * アクセス元のユーザIDを取得する
 *
 * @return string アクセス元のユーザID
 */
function api_user_id()
{
	global $__device;
	return $__device['user_id'];
}

?>