<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$module_version = array(
    'name' => 'Photo Album',
    'modfuncs' => 'main',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.4.01',
    'date' => 'Web, Aug 18, 2021 09:30:00 GMT+07:00',
    'author' => 'hugonhatnguyen (nguyentrongnhat230600@gmail.com)',
    'note' => '',
    'uploads_dir' => array(
        $module_upload,
    ),
    'assets_dir' => array(
        $module_upload,
    )
);
