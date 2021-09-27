<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

define('NV_IS_MOD_PRODUCT_INTRO', true);

$allow_func = array(
    'main',
    'show_list',
    'detail',
);

//--------------------------
// khai báo dùng chung:
//--------------------------
require_once NV_ROOTDIR . "/modules/" . $module_name . '/query_builder.php';
require_once NV_ROOTDIR . "/modules/" . $module_name . '/rules.php';
require_once NV_ROOTDIR . "/modules/" . $module_name . '/helper.php';
