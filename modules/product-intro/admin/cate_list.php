<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
$page_title = $lang_module['cate_list'];

//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$form_data = array();
$error = "";
$success = "";
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_cates = $query_builder->tb_cates;

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

$form_data = [
    'parent_id' => (int) $nv_Request->get_title('parent_id', 'post', 0),
    'name' => $nv_Request->get_title('name', 'post', ''),
    'alias' => $nv_Request->get_title('alias', 'post', ''),
    'active' => $nv_Request->get_title('check_active', 'post', ''),
    // edit:
    'id' => $nv_Request->get_title('id', 'post', 0),
    'url_action' => $base_url . $op
];

//============================================================================
// khi nhấn submit form:
if ($nv_Request->isset_request('form_submit', 'post')) {
    // sửa:
    if ($form_data['id'] > 0) {
        //valid:
        $error = $rules->updCateRules($form_data);

        if (empty($error)) {
            try {
                $query_update = $query_builder->updateCate(
                    $form_data['id'],
                    $form_data['parent_id'],
                    $form_data['name'],
                    $form_data['alias'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $result_update = $query_update->execute();
                $success = $lang_module['success_cate_update'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }
    // thêm:
    else {
        // valid:
        $error = $rules->insCateRules($form_data);

        if (empty($error)) {
            try {
                $query_insert_cate = $query_builder->insertCate(
                    ($form_data['parent_id'] > 0) ? $form_data['parent_id'] : 0,
                    $form_data['name'],
                    $form_data['alias'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $result_create = $query_insert_cate->execute(); // nạp vào db
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
    }
}

// xoá Danh mục:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id'] > 0 && md5($get_data['id'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        // valid:
        $error = $rules->delCateRules($get_data['id']);

        if (empty($error)) {
            $cate_del = $query_builder->getBy($tb_cates, "id = " . $get_data['id'])->fetch();

            // xoá:
            $query_builder->delCate($get_data['id']);

            // cập nhật lại weight:
            try {
                $list_behind = $query_builder->getBy($tb_cates, "weight > " . $cate_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
                $new_weight = $cate_del['weight'];
                foreach ($list_behind as $key => $behind) {
                    $query_update_new_weight = $query_builder->updateWeight($tb_cates, $behind['id'], $new_weight);
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

// thay đổi thứ tự (weight):
if($get_data['id'] && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $query_builder->getBy($tb_cates, "id != " . $get_data['id'], ['field_get' => 'id, weight', "order_by" => "weight ASC"]);
        
        $weight = 0;
        while ($cate = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $query_builder->updateWeight($tb_cates, $cate['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $query_builder->updateWeight($tb_cates, $get_data['id'], $new_weight);
            $result_update_weight = $query_update_new_weight->execute();
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
            $query_update_active = $query_builder->updateActive($tb_cates, $get_data['id'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

//=========[ show ]===========================================================
// khai báo mặc định:
$caption = $lang_module['create_cate'];
$list_parent_cate = $query_builder->getBy($tb_cates, "parent_id = 0")->fetchAll();

//== phân trang:
$perpage = 5;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $query_builder->countNumRows($tb_cates);
if ($totals > 0) {
    if ($totals <= (($page - 1) * $perpage) || !empty($result_create)) { // nếu tất cả record < số record của 1 trang (hoặc) sau khi thêm mới thành công thì show trang cuối
        $page = (ceil($totals/$perpage) > 0) ? ceil($totals/$perpage) : 1;
        nv_redirect_location($base_url . $op . "&amp;notify=true" . "&amp;page=" . $page);
    }
    if (!empty($result_update_weight)) { // show trang theo số thứ tự
        $page = ceil($new_weight / $perpage);
        nv_redirect_location($base_url . $op . "&amp;page=" . $page);
    }
    //
}

// show sửa:
if ($get_data['id'] > 0 && $nv_Request->isset_request('action_edit', 'get')) {
    $cate_edit = $query_builder->getBy($tb_cates, "id = " . $get_data['id'])->fetch();

    if (!empty($cate_edit)) {
        $cate_edit['active'] = ($cate_edit['active'] == 1) ? 'checked' : '';
        $form_data = $cate_edit;

        $caption = $lang_module['update_cate'] . ': <em>' . $cate_edit['name'] . '<em>';
        $form_data['url_action'] = $base_url . $op . '&amp;page=' . $page;
    } else { // valid:
        $error = $lang_module['valid_empty'];
    }
}

// show bảng danh mục:
try {
    $query_select = $query_builder->getAll($tb_cates, ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($cate = $query_select->fetch()) {
        $cate['active'] = ($cate['active'] == 1) ? 'checked' : '';
        $cate['parent'] = ($cate['parent_id'] > 0) ? $query_builder->getBy($tb_cates, "id = " . $cate['parent_id'])->fetch() : '';
        $cate['created_at'] = date('d-m-Y\ H:i A', $cate['created_at']);
        $cate['updated_at'] = ($cate['updated_at'] != 0) ? date("d-m-Y\ H:i A", $cate['updated_at']) : '';

        $list_cate[$cate['id']] = $cate;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

//=======[ thông báo & refresh form sau khi submit ]=======================
if ($nv_Request->isset_request('notify', 'get')) {
    $success = $lang_module['success_cate_create'];
}
if (!empty($error)) {
    $form_data['active'] = ($form_data['active'] == 'on') ? 'checked' : '';
} else {
    $form_data['active'] = 'checked';
}
if (!empty($success)) {
    $form_data = [
        'parent_id' => 0,
        'name' => '',
        'alias' => '',
        'active' => 'checked',
        'id' => 0,
        'url_action' => $base_url . $op . '&amp;page=' . $page
    ];
}

//------------------------------------------------
// Gọi teamplate và đổ DL
//------------------------------------------------
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_name . '/images'); // chỗ folder lưu ảnh đại diện
$xtpl->assign('OP', $op);
$xtpl->assign('PAGE', $page);

//=== xuất biến:
// thông báo:
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
if (!empty($success)) {
    $xtpl->assign('SUCCESS', $success);
    $xtpl->parse('main.success');
}

// show caption form:
if (!empty($caption)) {
    $xtpl->assign('CAPTION', $caption);
    $xtpl->parse('main.caption');
}

// hiển thị Danh mục cha:
if (!empty($list_parent_cate) && count($list_parent_cate) > 0) {
    $disabled = "";
    $option = '';

    foreach ($list_parent_cate as $key => $parent_cate) {
        // ko cho hiển thị cate đang sửa trong cate cha
        if (empty($cate_edit) || $parent_cate != $cate_edit) {
            // không được chọn cate cha nếu là cate cha:
            if ($form_data['id'] > 0) {
                $list_child_cate = $query_builder->getBy($tb_cates, "parent_id = " . $form_data['id'])->fetchAll();
                $disabled = (count($list_child_cate) > 0) ? 'disabled' : '';
            }
    
            $selected = ($form_data['parent_id'] == $parent_cate['id']) ? 'selected' : '';
            $option .= '<option  ' . $disabled . $selected . ' value="' . $parent_cate['id'] . '">' . $parent_cate['name'] . '</option>';
        }
    }
    $xtpl->assign('PARENT_OPTION', $option);
    $xtpl->parse('main.parent_cate');
}

// show bảng danh mục:
if (!empty($list_cate) && count($list_cate) > 0) {

    foreach ($list_cate as $key => $cate) {
        // cột stt:
        for ($i=1; $i <= $totals; $i++) {
            $xtpl->assign('STT', $i);
            $xtpl->assign('STT_SELECTED', ($i == $cate['weight']) ? "selected" : "");
            $xtpl->parse('main.loop.weight');
        }

        // show cate cha dưới name:
        if (!empty($cate['parent']) > 0) {
            $xtpl->assign('PARENT_CATE', $cate['parent']);
            $xtpl->parse('main.loop.parent_cate');
        }

        $cate['url_edit'] = $base_url . $op . "&amp;page=" . $page . "&amp;action_edit=true&amp;id=" . $cate['id'];
        $xtpl->assign('CATE', $cate);
        $xtpl->parse('main.loop');
    }

    // phân trang:
    if ($perpage < $totals) {
        $paginate = nv_generate_page($base_url . "cate_list", $totals, $perpage, $page);
        $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
        $xtpl->assign('PAGINATE', $paginate_html);
    }
} else {
    $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
    $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
    $xtpl->parse('main.notify');
}


// mặc định:
$xtpl->assign('FORM_DATA', $form_data);

//-------------------------------
// Viết code xuất ra site,
//-------------------------------
$xtpl->parse('main');
$contents = $xtpl->text('main');

//-------------------
// bắt buộc hiển thị:
//-------------------
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
