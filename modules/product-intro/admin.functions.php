<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_FILE_ADMIN', true);

$allow_func = array(
    'main',
    'product_content',
    'cate_list',
    'image_list',
    'slider_list',
);

//--------------------------
// khai báo dùng chung:
//--------------------------
require_once NV_ROOTDIR . "/modules/" . $module_name . '/query_builder.php';
require_once NV_ROOTDIR . "/modules/" . $module_name . '/rules.php';
require_once NV_ROOTDIR . "/modules/" . $module_name . '/helper.php';
