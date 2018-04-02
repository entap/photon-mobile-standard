<?php

/**
 * 最新のパッケージ一覧を更新する。
 *
 * 1 * * * * php <public>/batch/package_latest_build.php
 */

require_once __DIR__ . '/../system/photon/photon.php';
require_once __DIR__ . '/../system/admin/package_latest.php';

package_latest_build();
echo 'OK';

?>