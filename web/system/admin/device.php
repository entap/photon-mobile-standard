<?php

/**
 * デバイスを取得するSQLを生成する
 *
 * @param array $cond 検索条件
 *
 * @return string SQL
 */
function device_sql($cond)
{
	sql_clean();
	sql_table('device');
	sql_field('device.*');
	if (isset($cond['id']) && $cond['id'] !== '') {
		sql_where_integer('device.id', $cond['id']);
	}
	sql_order('device.id', FALSE);
	return sql_select();
}

/**
 * デバイスを取得する
 *
 * @param integer $id デバイスのID
 *
 * @return array デバイス
 */
function device_get($id)
{
	return db_select_row(device_sql(['id' => $id]));
}

?>