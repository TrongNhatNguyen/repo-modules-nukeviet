<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
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
$query_builder = new QueryBuilder();
$tb_albums = $query_builder->tb_albums;

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);

//----------------------------
$url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

// phân trang:
$perpage = 6;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $query_builder->countNumRows($tb_albums);

// hiển thị danh sách album:
try {
    $query_select = $query_builder->getAll($tb_albums, ['active' => 1, "order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($album = $query_select->fetch()) {
        $album['url_detail'] = nv_url_rewrite($url . "detail/" . $album['alias'] . "-" . $album['id'] . $global_config['rewrite_exturl']);

        $album['active'] = ($album['active'] == 1) ? 'checked' : '';
        $album['parent'] = ($album['parent_id'] > 0) ? $query_builder->getBy($tb_albums, "id = " . $album['parent_id'])->fetch() : '';
        
        $album['created_at'] = gmdate("d-m-Y\ H:i:s", $album['created_at']);
        $album['updated_at'] = ($album['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $album['updated_at']) : '';

        $list_album[$album['id']] = $album;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

//------------------------------
// Gọi file themes và đổ DL
//------------------------------
//----[ Thêm vào tiêu đề - SEO ]
$page_title = $lang_module['add'];
$key_words = $module_info['keywords'];
$array_mod_title[] = array(
    'title' => $lang_module['add'],
    'link' => nv_url_rewrite($url . $op, true)
);

$contents = nv_theme_photo_album_main($list_album, $totals, $perpage, $page);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
