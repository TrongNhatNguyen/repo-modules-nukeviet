<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
$page_title = $lang_module['add'];

//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$error = "";
$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_albums = $query_builder->tb_albums;
$tb_images = $query_builder->tb_images;

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

//===================================
// thay đổi thứ tự (weight):
if($get_data['id'] && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $query_builder->getBy($tb_albums, "id != " . $get_data['id'], ['field_get' => 'id, weight', "order_by" => "weight ASC"]);
        
        $weight = 0;
        while ($list_album = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $query_builder->updateWeight($tb_albums, $list_album['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $query_builder->updateWeight($tb_albums, $get_data['id'], $new_weight);
            $query_update_new_weight->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// thay đổi trạng thái (active):
if($get_data['id'] && $nv_Request->isset_request('change_active', 'get')) {
    $new_status = (int) $nv_Request->get_int('new_status', 'get', 0);

    if ($new_status == 0 || $new_status == 1) {
        try {
            $query_update_active = $query_builder->updateActive($tb_albums, $get_data['id'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// xoá album:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id'] > 0 && md5($get_data['id'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        // valid:
        $error = $rules->delAlbumRules($get_data['id']);

        if (empty($error)) {
            $album_del = $query_builder->getBy($tb_albums, "id = " . $get_data['id'])->fetch();

            // xoá:
            $query_builder->delAlbum($get_data['id']);

            // xoá kho image của album:
            $query_select = $query_builder->getBy($tb_images, "album_id = " . $get_data['id']);
            while ($image_del = $query_select->fetch()) {
                $query_builder->delImage($image_del['id']);
            }

            // cập nhật lại weight:
            try {
                $list_behind = $query_builder->getBy($tb_albums, "weight > " . $album_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
                $new_weight = $album_del['weight'];
                foreach ($list_behind as $key => $behind) {
                    $query_update_new_weight = $query_builder->updateWeight($tb_albums, $behind['id'], $new_weight);
                    $query_update_new_weight->execute();
                    $new_weight ++;
                }
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }

            die; // phản hồi ajax.
        } else {
            die($error); // phản hồi ajax.
        }
    }
}


//=========[ show ]==================
// phân trang:
$perpage = 5;
$totals = $query_builder->countNumRows($tb_albums);
$page = (int) $nv_Request->get_int('page', 'get', 1);
if ($totals <= (($page - 1) * $perpage)) {
    $page = (ceil($totals/$perpage) > 0) ? ceil($totals/$perpage) : 1;
}

// hiển thị bảng dl:
try {
    $query_select = $query_builder->getAll($tb_albums, ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($album = $query_select->fetch()) {
        $album['active'] = ($album['active'] == 1) ? 'checked' : '';
        $album['parent'] = ($album['parent_id'] > 0) ? $query_builder->getBy($tb_albums, "id = " . $album['parent_id'])->fetch() : '';
        $album['created_at'] = date('d-m-Y\ H:i A', $album['created_at']);
        $album['updated_at'] = ($album['updated_at'] != 0) ? date("d-m-Y\ H:i A", $album['updated_at']) : '';

        $list_album[$album['id']] = $album;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}


//------------------------------------------------
// Gọi teamplate và đổ DL
//------------------------------------------------
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('PAGE', $page);

//=== xuất biến:
if (!empty($list_album) && count($list_album) > 0) {
    $url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    
    foreach ($list_album as $key => $album) {
        // cột stt:
        for ($i=1; $i <= $totals; $i++) {
            $xtpl->assign('STT', $i);
            $xtpl->assign('STT_SELECTED', ($i == $album['weight']) ? "selected" : "");
            $xtpl->parse('main.loop.weight');
        }

        // show album gốc:
        if (!empty($album['parent']) > 0) {
            $xtpl->assign('PARENT_ALBUM', $album['parent']);
            $xtpl->parse('main.loop.parent_album');
        }

        $album['url_edit'] = $url . "album_content&amp;id=" . $album['id'];
        $album['url_image_update'] = $url . "image_list&amp;album_id=" . $album['id'];
        $xtpl->assign('ALBUM', $album);
        $xtpl->parse('main.loop');
    }

    // phân trang:
    if ($perpage < $totals) {
        $paginate = nv_generate_page($url . "main", $totals, $perpage, $page);
        $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
        $xtpl->assign('PAGINATE', $paginate_html);
    }
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
