<?php

// ビルド待ち
define('PACKAGE_BUILD_STATUS_WAIT', 1);

// ビルド進行中
define('PACKAGE_BUILD_STATUS_PROGRESS', 2);

// ビルド完了
define('PACKAGE_BUILD_STATUS_DONE', 3);

// ビルド失敗
define('PACKAGE_BUILD_STATUS_ERROR', 4);

/**
 * パッケージを構築する
 */
function package_build()
{
	// 構築待ちのパッケージIDを取得
	sql_clean();
	sql_table('package_build');
	sql_where_integer('package_build_status_id', PACKAGE_BUILD_STATUS_WAIT);
	sql_order('package_id');
	sql_limit(0, 1);
	$package_id = db_select_value(sql_select(), 'package_id');
	if ($package_id == NULL) {
		return;
	}

	// 構築中に設定
	package_build_progress($package_id, 0);

	// DBをエクスポート
	$filename = package_build_db($package_id);

	// 基準ディレクトリ
	$base_dir = rtrim(config('form_upload_dir'), '/') . '/';

	// package_dbを更新
	db_replace('package_db', [
		'package_id' => $package_id,
		'filename' => $filename,
		'filesize' => filesize($base_dir . $filename),
		'md5' => md5_file($base_dir . $filename)
	]);

	// 完了
	package_build_progress($package_id, 100);
}

/**
 * 現在進めているビルド処理の進行状態を設定する。
 *
 * @param $package_id integer パッケージID
 * @param $progress integer 進行度
 */
function package_build_progress($package_id, $progress)
{
	db_update_at('package_build', [
		'progress' => $progress,
		'package_build_status_id' => $progress >= 100 ? PACKAGE_BUILD_STATUS_DONE : PACKAGE_BUILD_STATUS_PROGRESS
	], $package_id);
}

/**
 * 現在進めているビルド処理のエラーメッセージを設定する。
 *
 * @param $package_id integer パッケージID
 * @param $message string メッセージ文字列
 */
function package_build_error($package_id, $message)
{
	db_update_at('package_build', [
		'package_build_status_id' => PACKAGE_BUILD_STATUS_ERROR,
		'message' => $message
	], $package_id);
	fatal('Build error: ' . $message);
}

/**
 * MySQLのテーブルから、SQLiteのDDLを生成する。
 *
 * @param $table string テーブル名
 * @return SQLiteのDDL
 */
function package_build_ddl($table)
{
	$ddl = 'CREATE TABLE ' . $table . ' (';
	$pk_flag = FALSE;
	foreach (db_describe($table) as $field) {
		// フィールド名
		$ddl .= $field['Field'] . ' ';

		// 型
		$type = strtok($field['Type'], '(');
		if (in_array($type, ['integer', 'int', 'smallint', 'tinyint', 'mediumint', 'bigint', 'year'])) {
			$ddl .= 'INTEGER';
		} else if (in_array($type, ['decimal', 'numeric', 'float', 'double'])) {
			$ddl .= 'REAL';
		} else if (in_array($type, ['tinyblob', 'blob', 'mediumblob', 'longblob'])) {
			$ddl .= 'BLOB';
		} else {
			$ddl .= 'TEXT';
		}

		// インデクス
		if ($field['Key'] == 'PRI' && $pk_flag === FALSE) {
			$pk_flag = TRUE;
			$ddl .= ' PRIMARY KEY';
		} else if ($field['Key'] == 'UNI') {
			$ddl .= ' UNIQUE';
		}

		// auto_increment
		if ($field['Extra'] == 'auto_increment') {
			$ddl .= ' AUTOINCREMENT';
		}
		$ddl .= ',';
	}
	$ddl = substr($ddl, 0, -1) . ');';
	return $ddl;
}

/**
 * MySQLのテーブルから、SQLiteのINSERT文を生成する。
 *
 * @param $table string テーブル名
 * @param $queries array SQLiteのINSERT文の配列
 */
function package_build_insert($table, &$queries)
{
	$result = db_query('SELECT * FROM ' . $table);
	while ($record = mysqli_fetch_assoc($result)) {
		$insert = 'INSERT INTO ' . $table . '(';
		$insert .= implode(', ', array_keys($record)) . ') VALUES (';
		foreach (array_values($record) as $value) {
			$insert .= "'" . str_replace("'", "''", $value) . "', ";
		}
		$insert = substr($insert, 0, -2) . ');';
		$queries[] = $insert;
	}
}

/**
 * SQLiteファイルを構築する
 *
 * @param $dir string 格納先のディレクトリ
 * @return string SQLiteファイル名
 */
function package_build_db($package_id, $dir = 'db')
{
	// SQLite3が利用可能か調べる
	if (!extension_loaded('sqlite3')) {
		package_build_error($package_id, 'SQLite3 extension is not loaded');
	}

	// 各テーブルの構成とデータをエクスポート
	$tables = db_select_column('SELECT name FROM package_table');
	$queries = [];
	foreach ($tables as $i => $table) {
		$queries[] = package_build_ddl($table);
		package_build_insert($table, $queries);
		package_build_progress($package_id, 10 + $i / count($tables) * 20);
	}

	// 基準ディレクトリ
	$base_dir = rtrim(config('form_upload_dir'), '/') . '/';

	// ディレクトリを生成する
	if (!file_exists($base_dir . $dir)) {
		mkdir($base_dir . $dir, 0777, TRUE);
	}

	// sqlite3のファイルを生成し、クエリを発行する。
	$tmp = $base_dir . $dir . '/' . uniqid();
	try {
		$db = new SQLite3($tmp);
		foreach ($queries as $i => $query) {
			if (!$db->query($query)) {
				package_build_error($package_id, $query . "\n" . $db->lastErrorMsg());
			}
			package_build_progress($package_id, 30 + $i / count($queries) * 20); // 進捗率
		}
		$db->close();
	} catch (Exception $exception) {
		echo $exception->getMessage();
	}

	// ファイル名を変更する
	$filename = $dir . '/' . md5_file($tmp);
	if (file_exists($filename)) {
		unlink($filename);
	}
	rename($tmp, $base_dir . $filename);

	return $filename;
}

?>