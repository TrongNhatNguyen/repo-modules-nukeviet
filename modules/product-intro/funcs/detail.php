<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_IS_MOD_PRODUCT_INTRO')) {
    die('Stop!!!');
}
$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------
$get_data = array();

$helper = new Helper();
$query_builder = new QueryBuilder();
$tb_cates = $query_builder->tb_cates;
$tb_products = $query_builder->tb_products;
$tb_images = $query_builder->tb_images;
$tb_sliders = $query_builder->tb_sliders;

// lấy ID từ url rewrite:
$line_array = explode('-', $array_op[1]);
end($line_array);
$get_data['id'] = $line_array[key($line_array)];

//----------------------------
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

// hiển thị nội dung chi tiết:
if ($get_data['id'] > 0) {
    $detail = $query_builder->getBy($tb_products, "id = " . $get_data['id'], ['active' => 1])->fetch();
    if (!empty($detail)) {
        try {
            $detail['publtime'] = $helper->getWeekdayVi($detail['created_at']);
            $detail['price'] = number_format($detail['price'], 0, '', ',');
            
            $image_list = $query_builder->getBy($tb_images, "product_id = " . $get_data['id'] . " AND active = 1")->fetchAll();
            $slider_list = $query_builder->getBy($tb_sliders, "product_id = " . $get_data['id'] . " AND active = 1")->fetchAll();
            $list_relate_prod  = $query_builder->getBy($tb_products, "cate_id = " . $detail['cate_id'] . " AND active = 1", ['litmit' => 5])->fetchAll();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    } else {
        // quay lại:
        nv_redirect_location(nv_url_rewrite($base_url . "main" . $global_config['rewrite_exturl']));
    }
} else {
    // quay lại:
    nv_redirect_location(nv_url_rewrite($base_url . "main" . $global_config['rewrite_exturl']));
}

//------------------------------
// Gọi file themes và đổ DL
//------------------------------
//----[ Thêm vào tiêu đề - SEO ]
$page_title = $detail['name'];
$key_words = $module_info['keywords'];
$array_mod_title[] = array(
    'title' => $lang_module['add'],
    'link' => nv_url_rewrite($base_url . "main" . $global_config['rewrite_exturl'], true)
);
$array_mod_title[] = array(
    'title' => $detail['name'],
    'link' => nv_url_rewrite($base_url . $op . "/" . $detail['alias'] . "-" . $detail['id']. $global_config['rewrite_exturl'], true)
);

$contents = nv_theme_product_intro_detail($detail, $list_relate_prod, $image_list, $slider_list);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
