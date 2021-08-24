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
$page_title = $lang_module['list_cate']; // hiển thị tiêu đề module

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------
$get_data = array();
$form_data = array();
$error = "";
$success = "";
$db_connect = new DBConnect();
$rules = new Rules();

// lấy dl url:
$get_data['id_edit'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

if ($nv_Request->isset_request('form_submit', 'post')) {
    $form_data = [
        'id_edit' => $nv_Request->get_title('id', 'post', 0),
        'name' => $nv_Request->get_title('name', 'post', ''),
        'alias' => $nv_Request->get_title('alias', 'post', ''),
        'active' => $nv_Request->get_title('check_active', 'post', 1)
    ];

    // thêm:
    if (!$form_data['id_edit']) {
        // valid:
        $error = $rules->insCateRules($form_data);

        if (!$error) {
            try {
                $query_insert = $db_connect->insertCate(
                    $form_data['name'],
                    $form_data['alias'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_insert->execute(); // nạp
                $success = $lang_module['success_cate_create'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }

    // sửa:
    if ($form_data['id_edit'] > 0) {
        // valid:
        $error = $rules->updCateRules($form_data);

        if (!$error) {
            try {
                $query_update = $db_connect->updateCate(
                    $form_data['id_edit'],
                    $form_data['name'],
                    $form_data['alias'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_update->execute();
                $success = $lang_module['success_cate_update'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }
}

// xoá:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id_edit'] > 0 && md5($get_data['id_edit'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        try {
            $result = $db_connect->delCate($get_data['id_edit']);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

if ($success) {
    $form_data = [];
}

//------------------------------
// phân trang:
$perpage = 6;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $db_connect->countNumRows("tbl_cates");
// hiển thị form:
$form_data['active'] = 'checked';

// show sửa:
if($get_data['id_edit'] && $nv_Request->isset_request('action_edit', 'get')) {
    $cate_edit = $db_connect->getBy("tbl_cates", "id =" . $get_data['id_edit'])->fetch();

    if ($form_data = $cate_edit) {
        $form_data['active'] = ($cate_edit['active'] == 1) ? 'checked' : '';
    } else { // valid:
        $error = $lang_module['valid_empty'];
    }
}

// hiển thị bảng:
try {
    $query_select = $db_connect->getAll("tbl_cates", ["limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    while ($cate = $query_select->fetch()) {
        $cate['active'] = ($cate['active'] == 1) ? $lang_module['active_1'] : $lang_module['active_0'];
        $cate['created_at'] = gmdate("d-m-Y\ H:i:s", $cate['created_at']);
        $cate['updated_at'] = ($cate['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $cate['updated_at']) : '';

        $list_cate[$cate['id']] = $cate;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die();
}


//------------------------------
// Gọi teamplate và đổ DL
//------------------------------
$xtpl = new XTemplate('list-cate.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

//-- xuất biến:
// alert:
if ($error) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
if ($success) {
    $xtpl->assign('SUCCESS', $success);
    $xtpl->parse('main.success');
}

// bảng:
if ($list_cate) {
    $i = ($page - 1) * $perpage;
    $url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    foreach ($list_cate as $key => $cate) {
        $cate['stt'] = $i + 1;
        $cate['url_edit'] = $url . "list-cate&amp;action_edit=true&amp;id=" . $cate['id'];
        $xtpl->assign('CATE', $cate);
        $xtpl->parse('main.loop');
        $i ++;
    }

    // phân trang:
    $paginate = nv_generate_page($url . "list-cate", $totals, $perpage, $page);
    $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
    $xtpl->assign('PAGINATE', $paginate_html);
} else {
    $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
    $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
    $xtpl->parse('main.notify');
}

$xtpl->assign('FORM_DATA', $form_data);

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
