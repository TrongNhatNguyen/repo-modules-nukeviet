<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jul 11, 2010 8:43:46 PM
 */

if (!defined('NV_IS_MOD_PHOTO_ALBUM')) { // thay đổi
    die('Stop!!!');
}

/**
 * nv_themes_photo_album_main()
 *
 * @param mixed $list_album
 * @return
 */
function nv_theme_photo_album_main($list_album)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //----------------------------------------
    // Khai báo các tham số dữ liệu
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $list_album['created_at']));
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $list_album['updated_at']));

    //--- xuất biến:
    if ($list_album) {
        $url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
        $i = 1;
        foreach ($list_album as $key => $album) {
            $album['stt'] = $i;
            $album['url_detail'] = $url . "detail&amp;id=" . $album['id'];
            $xtpl->assign('ALBUM', $album);
            $xtpl->parse('main.loop');
            $i++;
        }

        // phân trang:
        if ($perpage > $totals) {
            $paginate = nv_generate_page($url . "main", $totals, $perpage, $page);
            $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
            $xtpl->assign('PAGINATE', $paginate_html);
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
 * nv_themes_photo_album_detail()
 *
 * @param mixed $album_detail
 * @return
 */
function nv_theme_photo_album_detail($album_detail, $list_image_album)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //----------------------------------------
    // Khai báo các tham số dữ liệu
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $list_album['created_at']));
    $xtpl->assign('SCHEMA_DATEPUBLISHED', date('c', $list_album['updated_at']));

    //--- xuất biến:
    if ($album_detail) {
        if ($list_image_album) {
            foreach ($list_image_album as $key => $image_album) {
                $xtpl->assign('IMAGE', $image_album);
                $xtpl->parse('main.loop-image');

                if ($image_album['highlight'] == 1) {
                    $album_detail['highlight'] = $image_album;
                }
            }
        }

        $url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
        $xtpl->assign('DETAIL', $album_detail);
    } else {
        $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
        $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
        $xtpl->parse('main.notify');
    }


    $xtpl->parse('main');
    return $xtpl->text('main');
}
