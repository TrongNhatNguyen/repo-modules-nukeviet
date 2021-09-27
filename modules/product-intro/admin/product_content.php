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
$page_title = $lang_module['prod_content'];
if ($nv_Request->get_int('id', 'get', 0) || $nv_Request->get_title('id', 'post', 0)) {
    $page_title = $lang_module['prod_content_update'];
}


//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$form_data = array();
$error = "";
$success = "";
$helper = new Helper();
$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_cates = $query_builder->tb_cates;
$tb_products = $query_builder->tb_products;
$tb_images = $query_builder->tb_images;

// lấy dl từ url, form:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$form_data = [
    'cate_id' => $nv_Request->get_int('cate_id', 'post', 0),
    'name' => $nv_Request->get_title('name', 'post', ''),
    'alias' => $nv_Request->get_title('alias', 'post', ''),
    'price' => $nv_Request->get_int('price', 'post', 0),
    'feature_image_path' => $nv_Request->get_title('feature_image_path', 'post', ''),
    'description' => $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS),
    'content' => $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS),
    'active' => $nv_Request->get_title('check_active', 'post', ''),
    // edit:
    'id' => $nv_Request->get_int('id', 'post', 0),
];

//===================================
// khi nhấn submit form:
if ($nv_Request->isset_request('form_submit', 'post')) {
    // sửa:
    if ($form_data['id'] > 0) {
        //valid:
        $error = $rules->updProductRules($form_data);

        if (!$error) {
            try {
                $query_update = $query_builder->updateProduct(
                    $form_data['id'],
                    $form_data['cate_id'],
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['price'],
                    ($form_data['feature_image_path']) ? $form_data['feature_image_path'] : '/uploads/' . $module_name . '/no-image.png',
                    $form_data['description'],
                    $form_data['content'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_update->execute();
                $success = $lang_module['success_prod_update'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }
    // thêm:
    else {
        // valid:
        $error = $rules->insProductRules($form_data);

        if (!$error) {
            try {
                $query_insert_product = $query_builder->insertProduct(
                    $form_data['cate_id'],
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['price'],
                    ($form_data['feature_image_path']) ? $form_data['feature_image_path'] : '/uploads/' . $module_name . '/no-image.png',
                    $form_data['description'],
                    $form_data['content'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $result = $query_insert_product->execute(); // nạp vào db
                $success = $lang_module['success_prod_create'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
    }
}

//- trả về dl sau khi submit:
if (!empty($error)) {
    $form_data['active'] = ($form_data['active'] == 'on') ? 'checked' : '';
} else {
    $form_data['active'] = 'checked';
}
if (!empty($success)) {
    $form_data = [
        'cate_id' => 0,
        'name' => '',
        'alias' => '',
        'price' => 0,
        'feature_image_path' => '',
        'description' => '',
        'content' => '',
        'active' => 'checked',
        'id' => 0,
    ];
    
}

//=======[ show ]====================
// khai báo mặc định:
$list_cate = $query_builder->getAll($tb_cates, ['active' => 1])->fetchAll();

// show sửa:
if ($get_data['id'] > 0) {
    $product_edit = $query_builder->getBy($tb_products, "id = " . $get_data['id'])->fetch();

    if (!empty($product_edit)) {
        $product_edit['active'] = ($product_edit['active'] == 1) ? 'checked' : '';
        $form_data = $product_edit;
    } else { // valid:
        $error = $lang_module['valid_empty'];
    }
}

// show editor content:
if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$form_data['content'] = htmlspecialchars(nv_editor_br2nl($form_data['content']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $form_data['content'] = nv_aleditor('content', '100%', '200px', $form_data['content']);
} else {
    $form_data['content'] = '<textarea name="content" style="width:100%;height:200px;">' . $form_data['content'] . '</textarea>';
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
$xtpl->assign('MODULE_UPLOAD', $module_name . '/feature_image'); // chỗ folder lưu ảnh đại diện
$xtpl->assign('OP', $op);

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

// show danh mục:
if (!empty($list_cate) && count($list_cate) > 0) {
    $option = '<option value="0">-- chọn danh mục --</option>';
    $option .= $helper->rowsRecusive($list_cate, $form_data['cate_id']);

    $xtpl->assign('CATE_OPTION', $option);
    $xtpl->parse('main.cate_option');
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
