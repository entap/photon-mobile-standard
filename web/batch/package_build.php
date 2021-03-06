<?php

/**
 * 最新のパッケージ一覧を更新する。
 *
 * crontab
 * 1 * * * * php <public>/batch/package_build.php
 *
 * supervisord
 */

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/package_build.php';
require_once __DIR__ . '/../system/admin/package_latest.php';

// ビルド
package_build();

// 最新パッケージの更新
package_latest_build();

if ($_GET['sleep']) {
	sleep($_GET['sleep']);
}

?>