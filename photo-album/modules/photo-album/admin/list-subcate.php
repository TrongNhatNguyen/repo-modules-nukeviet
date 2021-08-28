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
$page_title = $lang_module['list_subcate']; // hiển thị tiêu đề module

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
$get_data['cate_id'] = (int) $nv_Request->get_int('cate_id', 'get', 0);
$get_data['id_edit'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

if ($nv_Request->isset_request('form_submit', 'post')) {
    $form_data = [
        'id_edit' => $nv_Request->get_title('id', 'post', 0),
        'name' => $nv_Request->get_title('name', 'post', ''),
        'alias' => $nv_Request->get_title('alias', 'post', ''),
        'cate_id' => $nv_Request->get_title('cate_id', 'post', ''),
        'active' => $nv_Request->get_title('check_active', 'post', 1)
    ];

    // thêm:
    if (!$form_data['id_edit']) {
        // valid:
        $error = $rules->insSubcateRules($form_data);

        if (!$error) {
            try {
                $query_insert = $db_connect->insertSubcate(
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['cate_id'],
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
        $error = $rules->updSubcateRules($form_data);

        if (!$error) {
            try {
                $query_update = $db_connect->updateSubcate(
                    $form_data['id_edit'],
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['cate_id'],
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
        $subcate_del = $db_connect->getBy("tbl_subcates", "id = " . $get_data['id_edit'])->fetch();
        try {
            $db_connect->delSubcate($get_data['id_edit']);

            // cập nhật lại weight:
            $list_behind = $db_connect->getBy("tbl_subcates", "weight > " . $subcate_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
            $new_weight = $subcate_del['weight'];
            foreach ($list_behind as $key => $behind) {
                $query_update_new_weight = $db_connect->updateWeight("tbl_subcates", $behind['id'], $new_weight);
                $query_update_new_weight->execute();
                $new_weight ++;
            }
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
$totals = $db_connect->countNumRows("tbl_subcates");
// hiển thị form:
$cate_search_option = '<option value="0">-- Tất cả --</option>';
$cate_option = '<option value="0">' . $lang_module['default_cate_option'] . '</option>';
$form_data['active'] = 'checked';

// show chuyên mục cha:
$list_cate = $db_connect->getAll("tbl_cates")->fetchAll();

// show sửa:
if($get_data['id_edit'] && $nv_Request->isset_request('action_edit', 'get')) {
    $subcate_edit = $db_connect->getBy('tbl_subcates', 'id = ' . $get_data['id_edit'])->fetch();

    if ($form_data = $subcate_edit) {
        $form_data['active'] = ($subcate_edit['active'] == 1) ? 'checked' : '';
    } else { // valid:
        $error = $lang_module['valid_empty'];
    }
}

// thay đổi thứ tự (weight):
if($get_data['id_edit'] && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $db_connect->getBy("tbl_subcates", "id != " . $get_data['id_edit'], ["field_get" => "id, weight", "order_by" => "weight ASC"]);
        
        $weight = 0;
        while ($list_subcate = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $db_connect->updateWeight("tbl_subcates", $list_subcate['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $db_connect->updateWeight("tbl_subcates", $get_data['id_edit'], $new_weight);
            $query_update_new_weight->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

// thay đổi trạng thái ẩn hiện:
if($get_data['id_edit'] && $nv_Request->isset_request('change_active', 'get')) {
    $new_status = (int) $nv_Request->get_int('new_status', 'get', 0);

    if ($new_status == 0 || $new_status == 1) {
        try {
            $query_update_active = $db_connect->updateActive("tbl_subcates", $get_data['id_edit'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }
}

// hiển thị bảng:
try {
    // hiển thị subcate theo cate:
    if ($get_data['cate_id'] && $nv_Request->isset_request('change_cate', 'get')) {
        $totals = $db_connect->countNumRows("tbl_subcates", "cate_id = " . $get_data['cate_id']);
        $query_select = $db_connect->getBy('tbl_subcates', 'cate_id = ' . $get_data['cate_id'], ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    } else {
        $query_select = $db_connect->getAll("tbl_subcates", ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    }

    while ($subcate = $query_select->fetch()) {
        $subcate['active'] = ($subcate['active'] == 1) ? 'checked' : '';
        $subcate['created_at'] = date("d-m-Y\ H:i A", $subcate['created_at']);
        $subcate['updated_at'] = ($subcate['updated_at'] != 0) ? date("d-m-Y\ H:i A", $subcate['updated_at']) : '';

        $list_subcate[$subcate['id']] = $subcate;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die();
}

//------------------------------
// Gọi teamplate và đổ DL
//------------------------------
$xtpl = new XTemplate('list-subcate.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
    foreach ($list_cate as $key => $cate) {
        $selected_search = ($cate['id'] == $get_data['cate_id']) ? 'selected' : '';
        $cate_search_option .= '<option ' . $selected_search . ' value="' . $cate['id'] . '">' . $cate['name'] . '</option>';
        $xtpl->assign('CATE_SEARCH_OPTION', $cate_search_option);
        $selected = ($cate['id'] == $form_data['cate_id']) ? 'selected' : '';
        $cate_option .= '<option ' . $selected . ' value="' . $cate['id'] . '">' . $cate['name'] . '</option>';
        $xtpl->assign('CATE_OPTION', $cate_option);
        $xtpl->parse('main.cate-loop');
    }
}
if ($list_subcate) {
    $url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
    
    foreach ($list_subcate as $key => $subcate) {
        // cột stt:
        for ($i=1; $i <= $totals; $i++) { 
            $xtpl->assign('STT', $i);
            $xtpl->assign('STT_SELECTED', ($i == $subcate['weight']) ? "selected" : "");
            $xtpl->parse('main.loop.weight');
        }

        $subcate['url_edit'] = $url . "list-subcate&amp;action_edit=true&amp;id=" . $subcate['id'];
        $xtpl->assign('SUBCATE', $subcate);
        $xtpl->parse('main.loop');
        $i ++;
    }

    // phân trang:
    if ($perpage < $totals) {
        $paginate = nv_generate_page($url . "list-subcate", $totals, $perpage, $page);
        $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
        $xtpl->assign('PAGINATE', $paginate_html);
    }
} else {
    $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
    $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
    $xtpl->parse('main.notify');
}

// form:
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
