<?php

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

// データベースの設定
config('db_hostname', getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost');
config('db_username', 'photon-mobile-standard');
config('db_password', '2tv8YdBAfuSL');
config('db_database', 'photon-mobile-standard');

// セッションの暗号化キー(32文字)
config('secret_key', '01234567890123456789012345678901');

?>
