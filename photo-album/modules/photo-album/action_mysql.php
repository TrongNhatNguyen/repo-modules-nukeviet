<?php
 
/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

// tên table:
$table_album = 'tbl_albums';
$table_image = 'tbl_images';
$table_cate = 'tbl_cates';
$table_subcate = 'tbl_subcates';


$sql_drop_module = array();

// Câu lệnh tạo tên các bảng:
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_album . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_image . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_cate . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_subcate . ";";
 
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_album . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`description` text,
`content` text NULL,
`cate_id` smallint(4) NOT NULL DEFAULT '0',
`subcate_id` smallint(4) NOT NULL DEFAULT '0',
`weight` int(11) NOT NULL DEFAULT '0',
`active` tinyint(2) NOT NULL DEFAULT '1',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
UNIQUE KEY `alias` (`alias`),
KEY `cate_id` (`cate_id`),
KEY `subcate_id` (`subcate_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_image . " (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`path` varchar(255) NOT NULL,
`highlight` tinyint(1) NOT NULL DEFAULT '0',
`album_id` int(11) NOT NULL DEFAULT '0',
`active` tinyint(2) NOT NULL DEFAULT '1',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
KEY `path` (`path`),
KEY `album_id` (`album_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_cate . " (
`id` smallint(4) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`weight` int(11) NOT NULL DEFAULT '0',
`active` tinyint(2) NOT NULL DEFAULT '1',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
UNIQUE KEY `alias` (`alias`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $table_subcate . " (
`id` smallint(4) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`cate_id` smallint(4) NOT NULL DEFAULT '0',
`weight` int(11) NOT NULL DEFAULT '0',
`active` tinyint(2) NOT NULL DEFAULT '1',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
UNIQUE KEY `alias` (`alias`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";
