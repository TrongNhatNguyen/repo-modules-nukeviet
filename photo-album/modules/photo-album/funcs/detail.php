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
$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------
$get_data = array();
$db_connect = new DBConnect();
$g_helper = new Helper();

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);

//----------------------------
// hiển thị nội dung chi tiết:
if ($get_data['id'] > 0) {
    try {
        $album_detail = $db_connect->getBy("tbl_albums", "id = " . $get_data['id'], ['active' => 1])->fetch();
        $list_image_album = $db_connect->getBy('tbl_images', "album_id = " . $get_data['id'])->fetchAll();
        $album_detail['publtime'] = $g_helper->getWeekdayVi($album_detail['created_at']);
    } catch (\PDOException $ex) {
        print_r($ex->getMessage());
        die();
    }
} else {
    // quay lại:
    $url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    nv_redirect_location($url . "main");
}

//------------------------------
// Gọi file themes và đổ DL
//------------------------------
$contents = nv_theme_photo_album_detail($album_detail, $list_image_album);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
