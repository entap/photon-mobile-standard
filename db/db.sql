-- MySQL Script generated by MySQL Workbench
-- Wed Mar 28 19:51:39 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mobile-standard
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mobile-standard
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mobile-standard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
USE `mobile-standard` ;

-- -----------------------------------------------------
-- Table `mobile-standard`.`admin_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`admin_user` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_role_id` INT NOT NULL COMMENT '管理ユーザの役割',
  `admin_group_id` INT NOT NULL COMMENT '管理グループ',
  `enable_flag` TINYINT NOT NULL COMMENT '有効か？',
  `name` VARCHAR(20) NOT NULL COMMENT 'フルネーム',
  `username` VARCHAR(20) NOT NULL COMMENT 'ユーザ名',
  `password` CHAR(64) NOT NULL COMMENT 'パスワード(SHA-256)',
  `email` VARCHAR(100) NOT NULL COMMENT 'メールアドレス',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
COMMENT = '管理ユーザ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`admin_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`admin_role` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  `roles` TEXT NOT NULL COMMENT '役割の一覧',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '管理ユーザの役割';


-- -----------------------------------------------------
-- Table `mobile-standard`.`m_admin_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`m_admin_role` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cd` VARCHAR(20) NOT NULL COMMENT '識別子',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cd_UNIQUE` (`cd` ASC))
ENGINE = InnoDB
COMMENT = '管理画面の役割';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_admin_login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_admin_login` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_user_id` INT NOT NULL COMMENT '管理ユーザ',
  `ip_address` VARCHAR(40) NOT NULL COMMENT 'IPアドレス',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `created` (`created` ASC))
ENGINE = InnoDB
COMMENT = '管理画面のログイン履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_admin_login_error`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_admin_login_error` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `ip_address` VARCHAR(40) NOT NULL COMMENT 'IPアドレス',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `created` (`created` ASC))
ENGINE = InnoDB
COMMENT = '管理画面のログイン失敗の履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`admin_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`admin_group` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '管理グループ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`property`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`property` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cd` VARCHAR(20) NOT NULL COMMENT '識別子',
  `property_type_id` INT NOT NULL COMMENT 'プロパティの型',
  `property_group_id` INT NOT NULL COMMENT 'プロパティのグループ',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  `description` TEXT NOT NULL COMMENT '説明文',
  `default_value` TEXT NOT NULL COMMENT 'デフォルト値',
  `order` INT NOT NULL COMMENT '順序',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cd` (`cd` ASC),
  INDEX `order` (`order` ASC))
ENGINE = InnoDB
COMMENT = 'プロパティ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`m_property_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`m_property_type` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cd` VARCHAR(20) NOT NULL COMMENT '識別子',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cd` (`cd` ASC))
ENGINE = InnoDB
COMMENT = 'プロパティの型';


-- -----------------------------------------------------
-- Table `mobile-standard`.`property_value`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`property_value` (
  `property_cd` VARCHAR(20) NOT NULL COMMENT 'プロパティの識別子',
  `value` TEXT NOT NULL COMMENT '値',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`property_cd`))
ENGINE = InnoDB
COMMENT = 'プロパティの値';


-- -----------------------------------------------------
-- Table `mobile-standard`.`property_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`property_group` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  `description` TEXT NOT NULL COMMENT '説明文',
  `order` INT NOT NULL COMMENT '順序',
  PRIMARY KEY (`id`),
  INDEX `order` (`order` ASC))
ENGINE = InnoDB
COMMENT = 'プロパティのグループ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_error`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_error` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `severity` VARCHAR(20) NOT NULL COMMENT '深刻度',
  `url` VARCHAR(100) NOT NULL COMMENT 'URL',
  `message` TEXT NOT NULL COMMENT 'エラーメッセージ',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `created` (`created` ASC))
ENGINE = InnoDB
COMMENT = 'エラー履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_mail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_mail` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `to` TEXT NOT NULL COMMENT '送信先',
  `from` TEXT NOT NULL COMMENT '送信元',
  `subject` TEXT NOT NULL COMMENT '題名',
  `message` TEXT NOT NULL COMMENT '本文',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'メール送信履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`sysmail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`sysmail` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `sysmail_type_id` INT NOT NULL COMMENT 'メールテンプレートの種類',
  `enable_flag` TINYINT NOT NULL COMMENT '有効か？',
  `period_flag` TINYINT NOT NULL COMMENT '有効期間を使うか？',
  `period_begin` DATETIME NOT NULL COMMENT '有効期間の開始日時',
  `period_end` DATETIME NOT NULL COMMENT '有効期間の終了日時',
  `name` VARCHAR(20) NOT NULL COMMENT '管理用の名前',
  `note` TEXT NOT NULL COMMENT 'メモ欄',
  `to` TEXT NOT NULL COMMENT '送信先メールアドレス',
  `from` VARCHAR(100) NOT NULL COMMENT '送信元メールアドレス',
  `subject` VARCHAR(100) NOT NULL COMMENT '題名',
  `message` TEXT NOT NULL COMMENT '本文',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'メールテンプレート';


-- -----------------------------------------------------
-- Table `mobile-standard`.`m_sysmail_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`m_sysmail_type` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cd` VARCHAR(20) NOT NULL COMMENT '識別子',
  `name` VARCHAR(20) NOT NULL COMMENT '名前',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cd` (`cd` ASC))
ENGINE = InnoDB
COMMENT = 'メールテンプレートの種類';


-- -----------------------------------------------------
-- Table `mobile-standard`.`m_platform`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`m_platform` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(10) NOT NULL COMMENT '名前',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'プラットフォーム';


-- -----------------------------------------------------
-- Table `mobile-standard`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `u` CHAR(32) NOT NULL COMMENT '識別子',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `u` (`u` ASC))
ENGINE = InnoDB
COMMENT = 'ユーザ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`device` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `d` CHAR(32) NOT NULL COMMENT '識別子',
  `platform_id` INT NOT NULL COMMENT 'プラットフォーム',
  `user_id` INT NOT NULL COMMENT 'ユーザ',
  `resolution_width` INT NOT NULL COMMENT '解像度 幅',
  `resolution_height` INT NOT NULL COMMENT '解像度 高さ',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `d` (`d` ASC),
  INDEX `platform_id` (`platform_id` ASC),
  INDEX `user_id` (`user_id` ASC))
ENGINE = InnoDB
COMMENT = 'デバイス';


-- -----------------------------------------------------
-- Table `mobile-standard`.`device_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`device_info` (
  `device_id` INT NOT NULL COMMENT 'デバイス',
  `device_model` VARCHAR(20) NOT NULL COMMENT 'デバイスのモデル',
  `device_name` VARCHAR(20) NOT NULL COMMENT 'デバイス名',
  `device_type` INT NOT NULL COMMENT 'デバイスのタイプ',
  `graphics_device_id` INT NOT NULL COMMENT 'グラフィックデバイスの識別コード',
  `graphics_device_name` VARCHAR(20) NOT NULL COMMENT 'グラフィックデバイス名',
  `graphics_device_type` INT NOT NULL COMMENT 'グラフィックデバイスのタイプ',
  `graphics_device_vendor` VARCHAR(20) NOT NULL COMMENT 'グラフィックデバイスのベンダー',
  `graphics_device_vendor_id` INT NOT NULL COMMENT 'グラフィックデバイスのベンダーの識別コード',
  `graphics_device_version` VARCHAR(20) NOT NULL COMMENT 'グラフィックデバイスのAPIとバージョン',
  `graphics_memory_size` INT NOT NULL COMMENT 'ビデオメモリ',
  `graphics_multi_threaded` TINYINT(1) NOT NULL COMMENT 'グラフィックデバイスがマルチスレッドレンダリングを行うか？',
  `graphics_shader_level` INT NOT NULL COMMENT 'グラフィックデバイスのシェーダーの性能レベル',
  `max_texture_size` INT NOT NULL COMMENT 'テクスチャの最大サイズ',
  `npot_support` INT NOT NULL COMMENT '対応しているNPOTテクスチャ',
  `operating_system` VARCHAR(20) NOT NULL COMMENT 'OSとバージョン',
  `processor_count` INT NOT NULL COMMENT 'プロセッサーの数',
  `processor_frequency` INT NOT NULL COMMENT 'プロセッサーの周波数',
  `processor_type` VARCHAR(20) NOT NULL COMMENT 'プロセッサー名',
  `supported_render_target_count` INT NOT NULL COMMENT 'レンダリングターゲットの数',
  `supports_2darray_textures` TINYINT(1) NOT NULL COMMENT '2D配列テクスチャに対応しているか？',
  `supports_3dtextures` TINYINT(1) NOT NULL COMMENT '3Dテクスチャに対応しているか？',
  `supports_accelerometer` TINYINT(1) NOT NULL COMMENT '加速度センサーに対応しているか？',
  `supports_audio` TINYINT(1) NOT NULL COMMENT 'オーディオに対応しているか？',
  `supports_compute_shaders` TINYINT(1) NOT NULL COMMENT 'ComputeShaderに対応しているか？',
  `supports_gyroscope` TINYINT(1) NOT NULL COMMENT 'ジャイロスコープに対応しているか？',
  `supports_image_effects` TINYINT(1) NOT NULL COMMENT 'イメージエフェクトに対応しているか？',
  `supports_instancing` TINYINT(1) NOT NULL COMMENT 'GPUドローコールのインスタンス化に対応しているか？',
  `supports_location_service` TINYINT(1) NOT NULL COMMENT 'GPSに対応しているか？',
  `supports_motion_vectors` TINYINT(1) NOT NULL COMMENT 'モーションベクターに対応しているか？',
  `supports_raw_shadow_depth_sampling` TINYINT(1) NOT NULL COMMENT 'シャドウマップからのサンプリングは生のデプスか？',
  `supports_render_textures` TINYINT(1) NOT NULL COMMENT 'レンダリングテクスチャに対応しているか？',
  `supports_render_to_cubemap` TINYINT(1) NOT NULL COMMENT 'キューブマップに対するレンダリングに対応しているか？',
  `supports_shadows` TINYINT(1) NOT NULL COMMENT '影に対応しているか？',
  `supports_sparse_textures` TINYINT(1) NOT NULL COMMENT 'スパーステクスチャに対応しているか？',
  `supports_stencil` TINYINT(1) NOT NULL COMMENT 'ステンシルバッファに対応しているか？',
  `supports_vibration` TINYINT(1) NOT NULL COMMENT 'バイブレーションに対応しているか？',
  `system_memory_size` INT NOT NULL COMMENT 'システムメモリ',
  PRIMARY KEY (`device_id`))
ENGINE = InnoDB
COMMENT = 'デバイス情報';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_device_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_device_user` (
  `id` INT NOT NULL COMMENT 'ID',
  `device_id` INT NOT NULL COMMENT 'デバイス',
  `user_id` INT NOT NULL COMMENT 'ユーザ',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `device_id` (`device_id` ASC),
  INDEX `user_id` (`user_id` ASC))
ENGINE = InnoDB
COMMENT = 'デバイスとユーザの履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`log_api`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`log_api` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `d` CHAR(32) NOT NULL COMMENT 'デバイスの識別子',
  `platform_id` INT NOT NULL COMMENT 'プラットフォーム',
  `app_version` INT NOT NULL COMMENT 'アプリのバージョン',
  `pkg_version` INT NOT NULL COMMENT 'パッケージのバージョン',
  `name` VARCHAR(50) NOT NULL COMMENT 'ファイル名',
  `param` LONGTEXT NOT NULL COMMENT '入力',
  `status` INT NOT NULL COMMENT '結果',
  `response` LONGTEXT NOT NULL COMMENT 'レスポンス',
  `message` VARCHAR(50) NOT NULL COMMENT 'エラー',
  `ip_address` VARCHAR(50) NOT NULL COMMENT 'アクセス元のIPアドレス',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `d` (`d` ASC),
  INDEX `platform_id` (`platform_id` ASC),
  INDEX `name` (`name` ASC),
  INDEX `created` (`created` ASC))
ENGINE = InnoDB
COMMENT = 'APIの履歴';


-- -----------------------------------------------------
-- Table `mobile-standard`.`device_test`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`device_test` (
  `device_id` INT NOT NULL COMMENT 'デバイス',
  `test_name` VARCHAR(50) NOT NULL COMMENT '試験用の名前',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`device_id`))
ENGINE = InnoDB
COMMENT = '試験用デバイス';


-- -----------------------------------------------------
-- Table `mobile-standard`.`device_resolution`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`device_resolution` (
  `id` INT NOT NULL COMMENT 'ID',
  `name` VARCHAR(50) NOT NULL COMMENT '名前',
  `resolution_width` INT NOT NULL COMMENT '解像度 幅',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'デバイスの解像度';


-- -----------------------------------------------------
-- Table `mobile-standard`.`app_version`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`app_version` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` INT NOT NULL COMMENT 'プラットフォーム',
  `app_version` INT NOT NULL COMMENT 'アプリのバージョン(3桁*3)',
  `expired_flag` TINYINT(1) NOT NULL COMMENT 'このバージョンは期限切れか？',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `platform_id` (`platform_id` ASC),
  INDEX `app_version` (`app_version` ASC))
ENGINE = InnoDB
COMMENT = 'アプリのバージョン';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `app_version_min` INT NOT NULL COMMENT '最小のアプリバージョン',
  `app_version_max` INT NOT NULL COMMENT '最大のアプリバージョン',
  `package_version` INT NOT NULL COMMENT 'パッケージのバージョン',
  `expired_flag` TINYINT(1) NOT NULL COMMENT '期限切れか？',
  `expired_date_flag` TINYINT(1) NOT NULL COMMENT '期限切れになる日時を指定するか？',
  `expired_date` DATETIME NOT NULL COMMENT '期限切れになる日時',
  `public_flag` TINYINT(1) NOT NULL COMMENT '公開中か？',
  `public_date_flag` TINYINT(1) NOT NULL COMMENT '公開日時を指定するか？',
  `public_date` DATETIME NOT NULL COMMENT '公開日時',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  `updated` DATETIME NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'パッケージ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_latest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_latest` (
  `app_version_id` INT NOT NULL COMMENT 'アプリのバージョン',
  `package_id` INT NOT NULL COMMENT 'パッケージ',
  INDEX `package_id` (`package_id` ASC),
  PRIMARY KEY (`app_version_id`))
ENGINE = InnoDB
COMMENT = '最新のパッケージ';


-- -----------------------------------------------------
-- Table `mobile-standard`.`file`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`file` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(50) NOT NULL COMMENT '元のファイル名',
  `filename` VARCHAR(50) NOT NULL COMMENT 'ファイル名',
  `filesize` INT NOT NULL COMMENT 'ファイルサイズ',
  `md5` CHAR(32) NOT NULL COMMENT 'ファイルのMD5',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'ファイル';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_file`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_file` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `device_resolution_id` INT NOT NULL COMMENT 'デバイスの解像度',
  `package_id` INT NOT NULL COMMENT 'パッケージ',
  `file_id` INT NOT NULL COMMENT 'ファイル',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `device_resolution_device_resolution_id1_idx` (`device_resolution_id` ASC),
  INDEX `package_package_id2_idx` (`package_id` ASC),
  INDEX `file_id` (`file_id` ASC))
ENGINE = InnoDB
COMMENT = 'パッケージに含まれるファイル';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_download`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_download` (
  `package_id` INT NOT NULL,
  `count` INT NOT NULL COMMENT 'ダウンロード数',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`package_id`))
ENGINE = InnoDB
COMMENT = 'パッケージのダウンロード数';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_build`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_build` (
  `package_id` INT NOT NULL,
  `done_flag` TINYINT(1) NOT NULL COMMENT '完了したか？',
  `progress` INT NOT NULL COMMENT '進行度',
  `message` VARCHAR(50) NOT NULL COMMENT 'メッセージ',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`package_id`))
ENGINE = InnoDB
COMMENT = 'パッケージのビルド状況';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_table`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_table` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(50) NOT NULL COMMENT 'パッケージ化するテーブル名',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'パッケージ化するテーブル名';


-- -----------------------------------------------------
-- Table `mobile-standard`.`package_db`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`package_db` (
  `package_id` INT NOT NULL,
  `filename` VARCHAR(50) NOT NULL COMMENT 'ファイル名',
  `filesize` INT NOT NULL COMMENT 'ファイルサイズ',
  `md5` CHAR(32) NOT NULL COMMENT 'ファイルのMD5',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`package_id`))
ENGINE = InnoDB
COMMENT = 'パッケージのSQLiteファイル';


-- -----------------------------------------------------
-- Table `mobile-standard`.`image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`image` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `file_id` INT NOT NULL COMMENT 'ファイル',
  `file_id_original` INT NOT NULL COMMENT 'リサイズ前のファイル',
  `device_resolution_id` INT NOT NULL COMMENT 'デバイスの解像度',
  `width` INT NOT NULL COMMENT '幅',
  `height` INT NOT NULL COMMENT '高さ',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `file_id` (`file_id` ASC),
  INDEX `device_resolution_id` (`device_resolution_id` ASC),
  INDEX `file_id_resized` (`file_id_original` ASC))
ENGINE = InnoDB
COMMENT = '画像ファイル';


-- -----------------------------------------------------
-- Table `mobile-standard`.`file_ref`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mobile-standard`.`file_ref` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `file_id` INT NOT NULL COMMENT 'ファイル',
  `ref` VARCHAR(50) NOT NULL COMMENT '参照元',
  `created` DATETIME NOT NULL COMMENT '作成日時',
  PRIMARY KEY (`id`),
  INDEX `file_id` (`file_id` ASC))
ENGINE = InnoDB
COMMENT = 'ファイルの参照';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mobile-standard`.`admin_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`admin_user` (`id`, `admin_role_id`, `admin_group_id`, `enable_flag`, `name`, `username`, `password`, `email`, `created`, `updated`) VALUES (1, 1, 1, 1, 'Administrator', 'admin', 'a7d026b5de30d5e0773a38324f84a73e5e8fa815641089ae835deaa02eed2f62', 'info@entap.co.jp', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mobile-standard`.`admin_role`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`admin_role` (`id`, `name`, `roles`, `created`, `updated`) VALUES (1, '特権', '*', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mobile-standard`.`m_admin_role`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, '*', '全ての操作');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'admin_user', 'すべての管理ユーザを管理');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'admin_user_local', '同じグループの管理ユーザを管理');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'admin_group', '管理グループを管理');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'admin_role', '管理ユーザの役割を管理');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'log', 'ログ');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'property', 'システム設定');
INSERT INTO `mobile-standard`.`m_admin_role` (`id`, `cd`, `name`) VALUES (DEFAULT, 'sysmail', 'メールテンプレート');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mobile-standard`.`admin_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`admin_group` (`id`, `name`) VALUES (1, '標準グループ');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mobile-standard`.`m_property_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`m_property_type` (`id`, `cd`, `name`) VALUES (1, 'integer', '整数');
INSERT INTO `mobile-standard`.`m_property_type` (`id`, `cd`, `name`) VALUES (2, 'decimal', '少数');
INSERT INTO `mobile-standard`.`m_property_type` (`id`, `cd`, `name`) VALUES (3, 'string', '文字列');
INSERT INTO `mobile-standard`.`m_property_type` (`id`, `cd`, `name`) VALUES (4, 'text', '複数行文字列');
INSERT INTO `mobile-standard`.`m_property_type` (`id`, `cd`, `name`) VALUES (5, 'boolean', '真偽値');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mobile-standard`.`m_platform`
-- -----------------------------------------------------
START TRANSACTION;
USE `mobile-standard`;
INSERT INTO `mobile-standard`.`m_platform` (`id`, `name`) VALUES (1, 'iOS');
INSERT INTO `mobile-standard`.`m_platform` (`id`, `name`) VALUES (2, 'Android');
INSERT INTO `mobile-standard`.`m_platform` (`id`, `name`) VALUES (3, 'Unknown');

COMMIT;

