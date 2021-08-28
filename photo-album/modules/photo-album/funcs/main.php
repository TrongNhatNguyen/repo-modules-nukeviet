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

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);

//-----------------
// phân trang:
$perpage = 6;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $db_connect->countNumRows("tbl_albums");

// hiển thị danh sách chính:
try {
    $query_select = $db_connect->getAll("tbl_albums", ['active' => 1, "order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($album = $query_select->fetch()) {
        $album['cate'] = $db_connect->getBy("tbl_cates", "id = " . $album['cate_id'])->fetch();
        $album['subcate'] = $db_connect->getBy("tbl_subcates", "id = " . $album['subcate_id'])->fetch();
        $album['active'] = ($album['active'] == 1) ? 'checked' : '';
        $album['created_at'] = gmdate("d-m-Y\ H:i:s", $album['created_at']);
        $album['updated_at'] = ($album['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $album['updated_at']) : '';

        if ($highlight = $db_connect->getBy("tbl_images", "album_id = " . $album['id'] . " AND highlight = 1")->fetch()) {
            $album['highlight'] = $highlight;
        }

        $list_album[$album['id']] = $album;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die();
}

//------------------------------
// Gọi file themes và đổ DL
//------------------------------
$contents = nv_theme_photo_album_main($list_album);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
