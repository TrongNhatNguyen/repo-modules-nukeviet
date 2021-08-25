<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
$page_title = $lang_module['add']; // hiển thị tiêu đề module

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------
$db_connect = new DBConnect();

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

// xoá:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id'] > 0 && md5($get_data['id'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        try {
            $result = $db_connect->delAlbum($get_data['id']);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

//-----------------
// phân trang:
$perpage = 6;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $db_connect->countNumRows("tbl_albums");

// thay đổi thứ tự (weight):
if($get_data['id'] && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $db_connect->getBy("tbl_albums", "id != " . $get_data['id'], ['field_get' => 'id, weight', "order_by" => "weight ASC"]);
        
        $weight = 0;
        while ($list_album = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $db_connect->updateWeight("tbl_albums", $list_album['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $db_connect->updateWeight("tbl_albums", $get_data['id'], $new_weight);
            $query_update_new_weight->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

// thay đổi trạng thái ẩn hiện:
if($get_data['id'] && $nv_Request->isset_request('change_active', 'get')) {
    $new_status = (int) $nv_Request->get_int('new_status', 'get', 0);

    if ($new_status == 0 || $new_status == 1) {
        try {
            $query_update_active = $db_connect->updateActive("tbl_albums", $get_data['id'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

// hiển thị bảng:
try {
    $query_select = $db_connect->getAll("tbl_albums", ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($album = $query_select->fetch()) {
        $album['cate'] = $db_connect->getBy("tbl_cates", "id = " . $album['cate_id'])->fetch();
        $album['subcate'] = $db_connect->getBy("tbl_subcates", "id = " . $album['subcate_id'])->fetch();
        $album['active'] = ($album['active'] == 1) ? 'checked' : '';
        $album['created_at'] = gmdate("d-m-Y\ H:i:s", $album['created_at']);
        $album['updated_at'] = ($album['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $album['updated_at']) : '';

        $list_album[$album['id']] = $album;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die();
}


//------------------------------
// Gọi teamplate và đổ DL
//------------------------------
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('MODULE_NAME', $module_name);

//-- xuất biến:
$xtpl->assign('', $op);

if ($list_album) {
    $url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    
    foreach ($list_album as $key => $album) {
        // cột stt:
        for ($i=1; $i <= $totals; $i++) { 
            $xtpl->assign('STT', $i);
            $xtpl->assign('STT_SELECTED', ($i == $album['weight']) ? "selected" : "");
            $xtpl->parse('main.loop.weight');
        }

        $album['url_edit'] = $url . "update-album&amp;id=" . $album['id'];
        $xtpl->assign('ALBUM', $album);
        $xtpl->parse('main.loop');
    }

    // phân trang:
    $paginate = nv_generate_page($url . "main", $totals, $perpage, $page);
    $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
    $xtpl->assign('PAGINATE', $paginate_html);
} else {
    $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
    $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
    $xtpl->parse('main.notify');
}

//-------------------------------
// Viết code xuất ra site vào đây: dựa vào <!-- BEGIN: --> và <!-- END: -->,
//-------------------------------
$xtpl->parse('main');
$contents = $xtpl->text('main');

//-------------------
// bắt buộc hiển thị:
//-------------------
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
