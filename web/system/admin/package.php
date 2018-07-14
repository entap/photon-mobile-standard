<?php

require_once __DIR__ . '/app_version.php';

/**
 * パッケージを取得するSQLを生成する
 *
 * @param array $cond 検索条件
 *
 * @return string SQL
 */
function package_sql($cond)
{
	sql_clean();
	sql_table('package');
	sql_field('package.*');
	sql_field('package_download.count', 'download_count');
	sql_field('package_build.done_flag');
	sql_field('package_build.progress');
	sql_field('package_build.message');
	if (isset($cond['id']) && $cond['id'] !== '') {
		sql_where_integer('package.id', $cond['id']);
	}
	sql_join('package_download', 'package_id', 'package', 'id');
	sql_join('package_build', 'package_id', 'package', 'id');
	sql_order('package.package_version', FALSE);
	return sql_select();
}

/**
 * パッケージを取得する
 *
 * @param integer $id パッケージの権限のID
 *
 * @return array パッケージの権限
 */
function package_get($id)
{
	$package = db_select_row(package_sql(['id' => $id]));
	$package['app_version_min'] = version_int2str($package['app_version_min']);
	$package['app_version_max'] = version_int2str($package['app_version_max']);
	$package['package_version'] = version_int2str($package['package_version']);
	return $package;
}

/**
 * パッケージの入力データをバリデーションする
 *
 * @param array $data 入力データ
 *
 * @return array 入力データのフィルタ結果
 */
function package_validate($data)
{
	$data['package']['expired_flag'] = intval($data['package']['expired_flag']);
	$data['package']['expired_date_flag'] = intval($data['package']['expired_date_flag']);
	$data['package']['public_flag'] = intval($data['package']['public_flag']);
	$data['package']['public_date_flag'] = intval($data['package']['public_date_flag']);
	form_date_convert($data, 'package[expired_date]');
	form_date_convert($data, 'package[public_date]');
	rule_clean();
	rule('package[id]');
	rule('package[app_version_min]', ['required' => 'yes', 'preg' => VERSION_PREG]);
	rule('package[app_version_max]', ['required' => 'yes', 'preg' => VERSION_PREG]);
	rule('package[package_version]', ['required' => 'yes', 'preg' => VERSION_PREG]);
	rule('package[expired_flag]', ['options' => 'boolean']);
	rule('package[expired_date_flag]', ['options' => 'boolean']);
	rule('package[expired_date]', ['required' => $data['package']['expired_date_flag']]);
	rule('package[public_flag]', ['options' => 'boolean']);
	rule('package[public_date_flag]', ['options' => 'boolean']);
	rule('package[public_date]', ['required' => $data['package']['public_flag']]);
	$data = filter($data);
	validate($data);
	return $data;
}

/**
 * パッケージの入力データを保存する
 *
 * @param array $data 入力データ
 * @param string $action 操作の種類
 *
 * @return integer ID
 */
function package_save($package)
{
	$package['app_version_min'] = version_str2int($package['app_version_min']);
	$package['app_version_max'] = version_str2int($package['app_version_max']);
	$package['package_version'] = version_str2int($package['package_version']);
	if ($package['id']) {
		db_update_at('package', $package, $package['id']);
		return $package['id'];
	} else {
		$packge_id = db_insert('package', $package);
		db_insert('package_build', [], $packge_id);
		db_insert('package_download', [], $packge_id);
	}
}

/**
 * パッケージを削除する
 *
 * @param integer $id パッケージの権限のID
 *
 * @return boolean 削除できたか？
 */
function package_delete($id)
{
	db_delete_at('package', $id);
	return TRUE;
}

/**
 * パッケージの状態の表示文字列
 *
 * @param $package パッケージの状態の表示文字列
 */
function package_status_display($package)
{
	if (!$package['done_flag']) {
		return '構築中 ' . $package['progress'] . '% ' . $package['message'];
	}
	if (!$package['public_flag']) {
		return '非公開';
	}
	if ($package['public_date_flag'] && $package['public_date'] > db_datetime()) {
		return date('Y-m-d H:i', strtotime($package['public_date'])) . 'まで非公開';
	}
	if ($package['expired_flag']) {
		if ($package['expired_date_flag'] && $package['expired_date'] > db_datetime()) {
			return '公開中 ' . date('Y-m-d H:i', strtotime($package['expired_date'])) . 'に期限切れ';
		} else {
			return '期限切れ';
		}
	}
	return '公開中';
}

?>