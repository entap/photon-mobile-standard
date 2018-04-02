<?php

/**
 * パッケージのテーブルの選択肢を取得する
 *
 * @return array パッケージのテーブルの選択肢
 */
function package_table_get_options()
{
	$options = db_select_column('SHOW TABLE STATUS', 'Name', 'Name');
	foreach (db_select_column('SELECT name FROM package_table') as $name) {
		unset($options[$name]);
	}
	return $options;
}

/**
 * パッケージのテーブルを取得するSQLを生成する
 *
 * @param array $cond 検索条件
 *
 * @return string SQL
 */
function package_table_sql($cond)
{
	sql_clean();
	sql_table('package_table');
	sql_field('package_table.*');
	if (isset($cond['id']) && $cond['id'] !== '') {
		sql_where_integer('package_table.id', $cond['id']);
	}
	sql_order('package_table.id', FALSE);
	return sql_select();
}

/**
 * パッケージを取得する
 *
 * @param integer $id パッケージの権限のID
 *
 * @return array パッケージの権限
 */
function package_table_get($id)
{
	return db_select_row(package_table_sql(['id' => $id]));
}

/**
 * パッケージの入力データをバリデーションする
 *
 * @param array $data 入力データ
 *
 * @return array 入力データのフィルタ結果
 */
function package_table_validate($data)
{
	rule_clean();
	rule('package_table[id]');
	rule('package_table[name]', ['required' => 'yes']);
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
function package_table_save($package_table)
{
	if ($package_table['id']) {
		db_update_at('package_table', $package_table, $package_table['id']);
		return $package_table['id'];
	} else {
		db_insert('package_table', $package_table);
	}
}

/**
 * パッケージを削除する
 *
 * @param integer $id パッケージの権限のID
 *
 * @return boolean 削除できたか？
 */
function package_table_delete($id)
{
	db_delete_at('package_table', $id);
	return TRUE;
}

?>