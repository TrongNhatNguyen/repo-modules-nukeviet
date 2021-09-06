<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_IS_MOD_PHOTO_ALBUM')) {
    die('Stop!!!');
}

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------
$get_data = array();
$helper = new Helper();
$query_builder = new QueryBuilder();
$tb_albums = $query_builder->tb_albums;
$tb_images = $query_builder->tb_images;

// lấy dl từ url rewrite:
$line_array = explode('-', $array_op[1]);
end($line_array);
$get_data['id'] = $line_array[key($line_array)];

//----------------------------
$url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

// hiển thị nội dung chi tiết:
if ($get_data['id'] > 0) {
    $detail = $query_builder->getBy($tb_albums, "id = " . $get_data['id'], ['active' => 1])->fetch();
    if (!empty($detail)) {
        try {
            $image_list = $query_builder->getBy($tb_images, "album_id = " . $get_data['id'])->fetchAll();
    
            $detail['publtime'] = $helper->getWeekdayVi($detail['created_at']);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    } else {
        // quay lại:
        nv_redirect_location($url . "main");
    }
} else {
    // quay lại:
    nv_redirect_location($url . "main");
}

//------------------------------
// Gọi file themes và đổ DL
//------------------------------
//----[ Thêm vào tiêu đề - SEO ]
$page_title = $detail['title'];
$key_words = $module_info['keywords'];
$array_mod_title[] = array(
    'title' => $lang_module['add'],
    'link' => nv_url_rewrite($url . "main", true)
);
$array_mod_title[] = array(
    'title' => $detail['title'],
    'link' => nv_url_rewrite($url . $op . "/" . $detail['alias'] . "-" . $detail['id']. $global_config['rewrite_exturl'], true)
);

$contents = nv_theme_photo_detail($detail, $image_list);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
