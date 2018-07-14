<?php

require_once __DIR__ . '/package_build.php';

/**
 * アプリのバージョンに対応した最新のパッケージを決定する。
 *
 * @param $app_version アプリのバージョン
 * @return array パッケージ
 */
function package_latest_determine($app_version)
{
	sql_clean();
	sql_table('package');
	sql_field('package.*');

	// バージョン
	sql_where_integer('app_version_min', $app_version, '<=');
	sql_where_integer('app_version_max', $app_version, '>=');

	// 公開中か？
	sql_where_integer('public_flag', 1);
	sql_where_begin('OR');
	sql_where_integer('public_date_flag', 0);
	sql_where_string('public_date', db_datetime(), '<=');
	sql_where_end();

	// 期限切れか？
	sql_where_begin('OR');
	sql_where_integer('expired_flag', 0);
	sql_where_begin('AND');
	sql_where_integer('expired_date_flag', 1);
	sql_where_string('expired_date', db_datetime(), '>=');
	sql_where_end();
	sql_where_end();

	// ビルド中でない事をチェック
	sql_join('package_build', 'package_id', 'package', 'id');
	sql_where_integer('package_build.package_build_status_id', PACKAGE_BUILD_STATUS_DONE);

	// 最新版
	sql_order('package_version', FALSE);
	sql_limit(0, 1);

	return db_select_row(sql_select());
}

/**
 * 最新のパッケージ一覧を更新する。
 */
function package_latest_build()
{
	$app_versions = db_select_table('SELECT * FROM app_version');
	foreach ($app_versions as $app_version) {
		$package = package_latest_determine($app_version['app_version']);
		db_replace('package_latest', [
			'app_version_id' => $app_version['id'],
			'package_id' => $package ? $package['id'] : 0,
		]);
	}
}

?>