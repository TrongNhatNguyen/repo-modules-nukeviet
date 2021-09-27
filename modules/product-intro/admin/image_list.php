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
$page_title = $lang_module['image_list'];

//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$form_data = array();
$error = "";
$success = "";
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

$helper = new Helper();
$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_products = $query_builder->tb_products;
$tb_images = $query_builder->tb_images;

// lấy dl từ url, form:
if (($product_id = $nv_Request->get_int('product_id', 'get', 0)) > 0) {
    $_SESSION["product_id"] = $product_id;
}
$get_data['product_id'] = $_SESSION["product_id"];

$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');
$form_data = [
    'path' => $nv_Request->get_title('path', 'post', ''),
    'highlight' => $nv_Request->get_title('check_highlight', 'post', ''),
    'active' => $nv_Request->get_title('check_active', 'post', ''),
];

$folder_name = '/uploads/' . $module_name . '/images/' . $get_data['product_id'] . '/';
// tạo folder chứa ảnh theo product nếu chưa có:
$dir = '..' . $folder_name;
if (!file_exists($dir) && !is_dir($dir)) {
    mkdir($dir, 0777);
} 
//===================================
// khi nhấn submit form - thêm:
if ($nv_Request->isset_request('form_submit', 'post')) {
    $get_name = str_replace($folder_name, '', $form_data['path']); // cắt đoạn đường dẫn phía trước
    $image_name = time() . "-" . $helper->convertNameFile($get_name);

    try {
        $query_insert = $query_builder->insertImage(
            $get_data['product_id'],
            $image_name,
            ($form_data['path']) ? $form_data['path'] : '/uploads/' . $module_name . '/no-image.png',
            ($form_data['highlight'] == 'on') ? 1 : 0,
            ($form_data['active'] == 'on') ? 1 : 0
        );
        $result = $query_insert->execute(); // nạp vào db
        $success = $lang_module['success_image_create'];
    } catch (\PDOException $ex) {
        print_r($ex->getMessage());
        die;
    }
}

// thay đổi thứ tự (weight):
if($get_data['id'] && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $query_builder->getBy(
            $tb_images,
            "product_id = " . $get_data['product_id'] . " AND id != " . $get_data['id'],
            ['field_get' => 'id, weight', "order_by" => "weight ASC"]
        );

        $weight = 0;
        while ($list_image = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $query_builder->updateWeight($tb_images, $list_image['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $query_builder->updateWeight($tb_images, $get_data['id'], $new_weight);
            $query_update_new_weight->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// thay đổi nổi bật (highlight):
if($get_data['id'] && $nv_Request->isset_request('change_highlight', 'get')) {
    $new_status = (int) $nv_Request->get_int('new_status', 'get', 0);

    if ($new_status == 0 || $new_status == 1) {
        try {
            $query_update_active = $query_builder->updateHighlight($tb_images, $get_data['id'], $new_status);
            $query_update_active->execute();
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
            $query_update_active = $query_builder->updateActive($tb_images, $get_data['id'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// xoá image:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id'] > 0 && md5($get_data['id'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        $image_del = $query_builder->getBy($tb_images, "product_id = " . $get_data['product_id'] . " AND id = " . $get_data['id'])->fetch();

        // xoá:
        $query_builder->delImage($get_data['id']);

        // cập nhật lại weight:
        try {
            $list_behind = $query_builder->getBy($tb_images, "product_id = " . $get_data['product_id'] . " AND weight > " . $image_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
            $new_weight = $image_del['weight'];
            foreach ($list_behind as $key => $behind) {
                $query_update_new_weight = $query_builder->updateWeight($tb_images, $behind['id'], $new_weight);
                $query_update_new_weight->execute();
                $new_weight ++;
            }
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

//- trả về dl sau khi submit:
if (!empty($error)) {
    $form_data['highlight'] = ($form_data['highlight'] == 'on') ? 'checked' : '';
    $form_data['active'] = ($form_data['active'] == 'on') ? 'checked' : '';
} else {
    $form_data['active'] = 'checked';
}
if (!empty($success)) {
    $form_data = [
        'name' => '',
        'path' => '',
        'highlight' => '',
        'active' => 'checked',
        'id' => 0,
    ];
    
}

//=======[ show ]====================
// khai báo mặc định:
$product = $query_builder->getBy($tb_products, "id = " . $get_data['product_id'])->fetch();

// phân trang
$perpage = 5;
$totals = $query_builder->countNumRows($tb_images, "product_id = " . $get_data['product_id']);
$page = (int) $nv_Request->get_int('page', 'get', 1);
if ($totals <= (($page - 1) * $perpage)) {
    $page = (ceil($totals/$perpage) > 0) ? ceil($totals/$perpage) : 1;
}

// hiển thị bảng dl ảnh:
try {
    $query_select = $query_builder->getBy($tb_images, "product_id = " . $get_data['product_id'], ["order_by" => "weight ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);

    while ($image = $query_select->fetch()) {
        $image['highlight'] = ($image['highlight'] == 1) ? 'checked' : '';
        $image['active'] = ($image['active'] == 1) ? 'checked' : '';
        $image['created_at'] = date('d-m-Y\ H:i A', $image['created_at']);
        $image['updated_at'] = ($image['updated_at'] != 0) ? date("d-m-Y\ H:i A", $image['updated_at']) : '';

        $list_image[$image['id']] = $image;
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
$xtpl->assign('MODULE_UPLOAD', $module_name . '/images'); // chỗ folder lưu ảnh đại diện
$xtpl->assign('PROD_ID', $get_data['product_id']);
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

// hiển thị tiêu đề product:
if (!empty($product)) {
    $xtpl->assign('PROD', $product);
    $xtpl->parse('main.product_name');
}

if (!empty($list_image) && count($list_image) > 0) {
    foreach ($list_image as $key => $image) {
        // cột stt:
        for ($i=1; $i <= $totals; $i++) {
            $xtpl->assign('STT', $i);
            $xtpl->assign('STT_SELECTED', ($i == $image['weight']) ? "selected" : "");
            $xtpl->parse('main.loop.weight');
        }

        $xtpl->assign('IMAGE', $image);
        $xtpl->parse('main.loop');
    }

    // phân trang:
    if ($perpage < $totals) {
        $paginate = nv_generate_page($base_url . "image_list", $totals, $perpage, $page);
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
