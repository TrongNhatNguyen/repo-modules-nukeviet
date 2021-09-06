<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jul 11, 2010 8:43:46 PM
 */

if (!defined('NV_IS_MOD_PHOTO_ALBUM')) {
    die('Stop!!!');
}

/**
 * nv_themes_photo_album_main()
 *
 * @param mixed $list_album
 * @param mixed $totals
 * @param mixed $perpage
 * @param mixed $page
 * @return
 */
function nv_theme_photo_album_main($list_album, $totals, $perpage, $page)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //--- xuất biến:
    $url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

    if (!empty($list_album) && count($list_album) > 0) {

        foreach ($list_album as $key => $album) {
            if (!empty($album['parent'])) {
                $xtpl->assign('PARENT', $album['parent']);
                $xtpl->parse('main.loop.parent');
            }

            $xtpl->assign('ALBUM', $album);
            $xtpl->parse('main.loop');
        }

        // phân trang:
        if (!empty($perpage) && !empty($totals) && !empty($page)) {
            if ($perpage > $totals) {
                $paginate = nv_generate_page(nv_url_rewrite($url . "main"), $totals, $perpage, $page);
                $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
                $xtpl->assign('PAGINATE', $paginate_html);
            }
        }
    } else {
        $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
        $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
        $xtpl->parse('main.notify');
    }


    $xtpl->parse('main');
    return $xtpl->text('main');
}


/**
 * nv_themes_photo_detail()
 *
 * @param mixed $detail
 * @param mixed $image_list
 * @return
 */
function nv_theme_photo_detail($detail, $image_list)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //----------------------------------------
    // Khai báo các tham số dữ liệu
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $detail['created_at']));
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $detail['updated_at']));

    //--- xuất biến:
    if (!empty($detail)) {
        $xtpl->assign('DETAIL', $detail);
        $xtpl->parse('main.detail');

        if (!empty($image_list) && count($image_list) > 0) {
            foreach ($image_list as $key => $image) {
                $xtpl->assign('IMAGE', $image);
                $xtpl->parse('main.loop_image');
            }
        }
    } else {
        $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
        $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
        $xtpl->parse('main.notify');
    }


    $xtpl->parse('main');
    return $xtpl->text('main');
}
