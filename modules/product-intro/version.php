<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = array(
    'name' => 'Product Introduction',
    'modfuncs' => 'main, show_list, detail',
    'change_alias' => 'main, show_list, detail',
    'submenu' => 'main',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.4.01',
    'date' => 'Web, September 10, 2021 09:30:00 GMT+07:00',
    'author' => 'hugonhatnguyen (nguyentrongnhat230600@gmail.com)',
    'note' => '',
    'uploads_dir' => array(
        $module_name,
        $module_upload,
    ),
    'assets_dir' => array(
        $module_name,
        $module_upload,
    )
);
