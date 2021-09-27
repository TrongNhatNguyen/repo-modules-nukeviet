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
$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

//------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------
$url_redirect = array();

$query_builder = new QueryBuilder();
$tb_products = $query_builder->tb_products;
$tb_sliders = $query_builder->tb_sliders;
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

//=================================
// hiển thị 3 sản phẩm ngẫu nhiên:
try {
    $query_select = $query_builder->getAll($tb_products, ['active' => 1, "order_by" => "RAND()", "limit" => 3]);
    $list_random_product = [];
    while ($product = $query_select->fetch()) {
        $product['url_detail'] = nv_url_rewrite($base_url . "detail/" . $product['alias'] . "-" . $product['id'] . $global_config['rewrite_exturl']);
        $product['slider'] = $query_builder->getBy($tb_sliders, "product_id = " . $product['id'], ['limit' => 1])->fetch();
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        
        $product['created_at'] = gmdate("d-m-Y\ H:i:s", $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $product['updated_at']) : '';

        $list_random_product[$product['id']] = $product;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

// hiển thị 5 sản phẩm mới nhất:
try {
    $query_select = $query_builder->getAll($tb_products, ['active' => 1, "limit" => 5]);
    $list_new_product = [];
    while ($product = $query_select->fetch()) {
        $product['url_detail'] = nv_url_rewrite($base_url . "detail/" . $product['alias'] . "-" . $product['id'] . $global_config['rewrite_exturl']);
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        
        $product['created_at'] = gmdate("d-m-Y\ H:i:s", $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $product['updated_at']) : '';

        $list_new_product[$product['id']] = $product;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

// hiển thị tất cả sản phẩm (6 sp):
try {
    $query_select = $query_builder->getAll($tb_products, ['active' => 1, "order_by" => "id ASC", "limit" => 6]);
    $list_product = [];
    while ($product = $query_select->fetch()) {
        $product['url_detail'] = nv_url_rewrite($base_url . "detail/" . $product['alias'] . "-" . $product['id'] . $global_config['rewrite_exturl']);
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        
        $product['created_at'] = gmdate("d-m-Y\ H:i:s", $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $product['updated_at']) : '';

        $list_product[$product['id']] = $product;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

// chuyển hướng đến trang tất cả sản phẩm:
$url_redirect['show_list'] = nv_url_rewrite($base_url . "show_list" . $global_config['rewrite_exturl']);

//---------------------------------------------
// Gọi file themes và đổ DL
//---------------------------------------------
//----[ Thêm vào tiêu đề - SEO ]
$page_title = $lang_module['add'];
$key_words = $module_info['keywords'];

//----[ breadcrumb ]
$array_mod_title[] = array(
    'title' => $lang_module['add'],
    'link' => nv_url_rewrite($base_url . $op, true)
);

$contents = nv_theme_product_intro_main($list_product, $list_random_product, $list_new_product, $url_redirect);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
