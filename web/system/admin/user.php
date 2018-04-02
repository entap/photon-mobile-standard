<?php

/**
 * ユーザを取得するSQLを生成する
 *
 * @param array $cond 検索条件
 *
 * @return string SQL
 */
function user_sql($cond)
{
	sql_clean();
	sql_table('user');
	sql_field('user.*');
	if (isset($cond['id']) && $cond['id'] !== '') {
		sql_where_integer('user.id', $cond['id']);
	}
	sql_order('user.id', FALSE);
	return sql_select();
}

/**
 * ユーザを取得する
 *
 * @param integer $id ユーザのID
 *
 * @return array ユーザ
 */
function user_get($id)
{
	return db_select_row(user_sql(['id' => $id]));
}

?>