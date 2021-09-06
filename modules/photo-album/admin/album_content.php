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
$page_title = $lang_module['album_content'];
if ($nv_Request->get_int('id', 'get', 0) || $nv_Request->get_title('id', 'post', 0)) {
    $page_title = $lang_module['album_content_update'];
}


//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$form_data = array();
$error = "";
$success = "";
$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_albums = $query_builder->tb_albums;

// lấy dl từ url, form:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$form_data = [
    'parent_id' => (int) $nv_Request->get_title('parent_id', 'post', 0),
    'title' => $nv_Request->get_title('title', 'post', ''),
    'alias' => $nv_Request->get_title('alias', 'post', ''),
    'feature_image_path' => $nv_Request->get_title('feature_image_path', 'post', ''),
    'description' => $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS),
    'content' => $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS),
    'active' => $nv_Request->get_title('check_active', 'post', ''),
    // edit:
    'id' => $nv_Request->get_title('id', 'post', 0),
];

//===================================
// khi nhấn submit form:
if ($nv_Request->isset_request('form_submit', 'post')) {
    // sửa:
    if ($form_data['id'] > 0) {
        //valid:
        $error = $rules->updAlbumRules($form_data);

        if (!$error) {
            try {
                $query_update = $query_builder->updateAlbum(
                    $form_data['id'],
                    $form_data['parent_id'],
                    $form_data['title'],
                    $form_data['alias'],
                    ($form_data['feature_image_path']) ? $form_data['feature_image_path'] : '/uploads/' . $module_name . '/no-image.png',
                    $form_data['description'],
                    $form_data['content'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_update->execute();
                $success = $lang_module['success_alb_update'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }
    // thêm:
    else {
        // valid:
        $error = $rules->insAlbumRules($form_data);

        if ($error == null) {
            try {
                $query_insert_album = $query_builder->insertAlbum(
                    ($form_data['parent_id'] > 0) ? $form_data['parent_id'] : 0,
                    $form_data['title'],
                    $form_data['alias'],
                    ($form_data['feature_image_path']) ? $form_data['feature_image_path'] : '/uploads/' . $module_name . '/no-image.png',
                    $form_data['description'],
                    $form_data['content'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_insert_album->execute(); // nạp vào db
                $result = $query_insert_album->fetch(); // lấy dl vừa nạp
                $success = $lang_module['success_alb_create'];
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
        'parent_id' => 0,
        'title' => '',
        'alias' => '',
        'feature_image_path' => '',
        'description' => '',
        'content' => '',
        'active' => 'checked',
        'id' => 0,
    ];
    
}

//=======[ show ]====================
// khai báo mặc định:
$list_parent_album = $query_builder->getBy($tb_albums, "parent_id = 0")->fetchAll();

// show sửa:
if ($get_data['id'] > 0) {
    $album_edit = $query_builder->getBy($tb_albums, "id = " . $get_data['id'])->fetch();

    if (!empty($album_edit)) {
        $album_edit['active'] = ($album_edit['active'] == 1) ? 'checked' : '';
        $form_data = $album_edit;
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
$xtpl->assign('MODULE_UPLOAD', $module_name . '/feature-image'); // chỗ folder lưu ảnh đại diện
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

// hiển thị album cha:
if (!empty($list_parent_album) && count($list_parent_album) > 0) {
    $disabled = "";
    $option = '<option value="0">' . $lang_module['def_parent_option'] . '</option>';

    foreach ($list_parent_album as $key => $parent_album) {
        // không được chọn alb cha nếu có alb con:
        if ($form_data['id'] > 0) {
            $list_child_album = $query_builder->getBy($tb_albums, "parent_id = " . $form_data['id'])->fetchAll();
            $disabled = (count($list_child_album) > 0) ? 'disabled' : '';
        }

        $selected = ($form_data['parent_id'] == $parent_album['id']) ? 'selected' : '';
        $option .= '<option  ' . $disabled . $selected . ' value="' . $parent_album['id'] . '">' . $parent_album['title'] . '</option>';

        $xtpl->assign('PARENT_OPTION', $option);
        $xtpl->parse('main.loop-parent');
    }
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
