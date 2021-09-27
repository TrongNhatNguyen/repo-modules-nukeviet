<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_IS_MOD_PRODUCT_INTRO')) {
    die('Stop!!!');
}

/**
 * nv_theme_product_intro_main()
 *
 * @param mixed $list_product
 * @param mixed $list_random_product
 * @param mixed $list_new_product
 * @param mixed $url_redirect
 * @return
 */
function nv_theme_product_intro_main($list_product, $list_random_product, $list_new_product, $url_redirect)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('URL_REDIRECT', $url_redirect);
    //--- xuất biến:
    $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

    //======================
    // danh sách tất cả sp:
    if (!empty($list_product) && count($list_product) > 0) {

        foreach ($list_product as $key => $product) {
            $xtpl->assign('PROD', $product);
            $xtpl->parse('main.check_records.loop');
        }

        // 3 sản phẩm ngẫu nhiên:
        if (!empty($list_random_product) && count($list_random_product) > 0) {
            foreach ($list_random_product as $key => $product) {
                $xtpl->assign('R_PROD', $product);
                $xtpl->parse('main.check_records.loop_random_prod');
            }
        }

        // 5 sản phẩm mới nhất:
        if (!empty($list_new_product) && count($list_new_product) > 0) {
            foreach ($list_new_product as $key => $product) {
                $xtpl->assign('N_PROD', $product);
                $xtpl->parse('main.check_records.loop_new_prod');
            }
        }

        // kiểm tra có dữ liệu hiển thị:
        $xtpl->parse('main.check_records');
    } else {
        $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
        $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
        $xtpl->parse('main.notify');
    }

    

    $xtpl->parse('main');
    return $xtpl->text('main');
    $xtpl->out('main');
}


/**
 * nv_theme_product_intro_show_list()
 *
 * @param mixed $list_product
 * @param mixed $list_new_product
 * @param mixed $search_data
 * @param mixed $cate_option
 * @param mixed $paginate
 * @return
 */
function nv_theme_product_intro_show_list($list_product, $list_new_product, $search_data, $cate_option, $paginate)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //--- xuất biến:
    $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    $perpage = $paginate['perpage'];
    $page = $paginate['page'];
    $totals = $paginate['totals'];

    //======================
    // tất cả sản phẩm:
    if (!empty($list_product) && count($list_product) > 0) {
        foreach ($list_product as $key => $product) {
            $xtpl->assign('PROD', $product);
            $xtpl->parse('main.check_records.loop');
        }

        // phân trang:
        if (!empty($perpage) && !empty($page) && !empty($totals)) {
            if ($perpage < $totals) {
                $paginate = nv_generate_page(nv_url_rewrite($base_url . $op), $totals, $perpage, $page);
                $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
                $xtpl->assign('PAGINATE', $paginate_html);
            }
        }

        // 5 sản phẩm mới nhất:
        if (!empty($list_new_product) && count($list_new_product) > 0) {
            foreach ($list_new_product as $key => $product) {
                $xtpl->assign('N_PROD', $product);
                $xtpl->parse('main.check_records.loop_new_prod');
            }
        }

        // hiển thị dm search:
        if (!empty($cate_option)) {
            $xtpl->assign('CATE_OPTION', $cate_option);
            $xtpl->parse('main.check_records.cate_option');
        }

        // mặc định:
        $xtpl->assign('SEARCH_DATA', $search_data);

        // kiểm tra có dữ liệu hiển thị:
        $xtpl->parse('main.check_records');
    } else {
        $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
        $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
        $xtpl->parse('main.notify');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
    $xtpl->out('main');
}


/**
 * nv_theme_product_intro_detail()
 *
 * @param mixed $detail
 * @param mixed $list_relate_prod
 * @param mixed $image_list
 * @param mixed $slider_list
 * @return
 */
function nv_theme_product_intro_detail($detail, $list_relate_prod, $image_list, $slider_list)
{
    global $op, $module_name, $lang_module, $lang_global, $module_info, $global_config;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('SCHEMA_ORGNAME', $global_config['site_name']);
    $xtpl->assign('OP', $op);

    //--- xuất biến:
    if (!empty($detail)) {
        $xtpl->assign('DETAIL', $detail);
        $xtpl->parse('main.detail');

        // hiển thị hình ảnh:
        if (!empty($image_list) && count($image_list) > 0) {
            foreach ($image_list as $key => $image) {
                $xtpl->assign('IMAGE', $image);
                $xtpl->parse('main.loop_image');
                $xtpl->assign('IMAGE', $image);
                $xtpl->parse('main.loop_image_nw');
            }
        }

        // hiển thị slider:
        if (!empty($slider_list) && count($slider_list) > 0) {
            foreach ($slider_list as $key => $slider) {
                $xtpl->assign('SLIDER', $slider);
                $xtpl->parse('main.loop_slider');
            }
        }

        // hiển thị các sp liên quan:
        if (!empty($list_relate_prod) && count($list_relate_prod) > 0) {
            foreach ($list_relate_prod as $key => $prod) {
                $prod['price'] = number_format($prod['price'], 0, '', ',');
                $xtpl->assign('RE_PROD', $prod);
                $xtpl->parse('main.loop_relate_prod');
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
