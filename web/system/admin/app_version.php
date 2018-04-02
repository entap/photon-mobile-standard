<?php

/// バージョンの正規表現
define('VERSION_PREG', '/^[0-9]{1,3}(\.[0-9]{1,3}(\.[0-9]{1,3})?)?$/');

/**
 * バージョンを文字列から数字に変換する
 *
 * @param $version_str string バージョンの文字列
 * @return integer バージョンの整数値
 */
function version_str2int($version_str)
{
	list($x, $y, $z) = explode('.', $version_str);
	return sprintf('%03d%03d%03d', intval($x), intval($y), intval($z));
}

/**
 * バージョンを数字から文字列に変換する
 *
 * @param $version_int integer バージョンの整数値
 * @return string バージョンの文字列
 */
function version_int2str($version_int)
{
	list($x, $y, $z) = str_split(sprintf('%09d', $version_int), 3);
	return intval($x) . '.' . intval($y) . '.' . intval($z);
}

/**
 * アプリのバージョンを取得するSQLを生成する
 *
 * @param array $cond 検索条件
 *
 * @return string SQL
 */
function app_version_sql($cond)
{
	sql_clean();
	sql_table('app_version');
	sql_field('app_version.*');
	sql_field('package.package_version');
	if (isset($cond['platform_id']) && $cond['platform_id'] !== '') {
		sql_where_search(['app_version.platform_id'], $cond['platform_id']);
	}
	if (isset($cond['id']) && $cond['id'] !== '') {
		sql_where_integer('app_version.id', $cond['id']);
	}
	sql_join('package_latest', 'app_version_id', 'app_version', 'id');
	sql_join('package', 'id', 'package_latest', 'package_id');
	sql_order('app_version.app_version', FALSE);
	return sql_select();
}

/**
 * アプリのバージョンを取得する
 *
 * @param integer $id アプリのバージョンの権限のID
 *
 * @return array アプリのバージョンの権限
 */
function app_version_get($id)
{
	$app_version = db_select_row(app_version_sql(['id' => $id]));
	$app_version['app_version'] = version_int2str($app_version['app_version']);
	return $app_version;
}

/**
 * アプリのバージョンの入力データをバリデーションする
 *
 * @param array $data 入力データ
 *
 * @return array 入力データのフィルタ結果
 */
function app_version_validate($data)
{
	$data['app_version']['expired_flag'] = intval($data['app_version']['expired_flag']);
	rule_clean();
	rule('app_version[id]');
	rule('app_version[platform_id]', ['required' => 'yes']);
	rule('app_version[app_version]', ['required' => 'yes', 'preg' => VERSION_PREG]);
	rule('app_version[expired_flag]', ['required' => 'yes', 'options' => 'boolean']);
	$data = filter($data);
	validate($data);
	return $data;
}

/**
 * アプリのバージョンの入力データを保存する
 *
 * @param array $data 入力データ
 * @param string $action 操作の種類
 *
 * @return integer ID
 */
function app_version_save($app_version)
{
	$app_version['app_version'] = version_str2int($app_version['app_version']);
	if ($app_version['id']) {
		db_update_at('app_version', $app_version, $app_version['id']);
		return $app_version['id'];
	} else {
		return db_insert('app_version', $app_version);
	}
}

/**
 * アプリのバージョンを削除する
 *
 * @param integer $id アプリのバージョンの権限のID
 *
 * @return boolean 削除できたか？
 */
function app_version_delete($id)
{
	db_delete_at('app_version', $id);
	return TRUE;
}

?>