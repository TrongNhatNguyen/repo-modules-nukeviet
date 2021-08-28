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
$page_title = $lang_module['update_album']; // hiển thị tiêu đề module

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

// @submit:
if ($nv_Request->isset_request('form_submit', 'post')) {
    $form_data = [
        'id_edit' => $nv_Request->get_title('id', 'post', 0),
        'name' => $nv_Request->get_title('name', 'post', ''),
        'alias' => $nv_Request->get_title('alias', 'post', ''),
        'image' => $nv_Request->get_title('image', 'post', ''),
        'highlight' => $nv_Request->get_title('check_highlight', 'post', ''),
        'description' => $nv_Request->get_editor('description', '(no infomation)', NV_ALLOWED_HTML_TAGS),
        'content' => $nv_Request->get_editor('content', '(no infomation)', NV_ALLOWED_HTML_TAGS),
        'cate_id' => $nv_Request->get_title('cate_id', 'post', ''),
        'subcate_id' => $nv_Request->get_title('subcate_id', 'post', ''),
        'active' => $nv_Request->get_title('check_active', 'post', 1),
    ];

    // thêm:
    if (!$form_data['id_edit']) {
        // valid:
        $error = $rules->insAlbumRules($form_data);

        if (!$error) {
            try {
                $query_insert_album = $db_connect->insertAlbum(
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['description'],
                    $form_data['content'],
                    $form_data['cate_id'],
                    $form_data['subcate_id'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_insert_album->execute(); // nạp vào db

                $album_id_insert_image = $db_connect->getLastRows("tbl_albums")->fetchColumn();
                $success = $lang_module['success_alb_create'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }

    // sửa:
    if ($form_data['id_edit'] > 0) {
        //valid:
        $error = $rules->updAlbumRules($form_data);

        if (!$error) {
            try {
                $query_update = $db_connect->updateAlbum(
                    $form_data['id_edit'],
                    $form_data['name'],
                    $form_data['alias'],
                    $form_data['description'],
                    $form_data['content'],
                    $form_data['cate_id'],
                    $form_data['subcate_id'],
                    ($form_data['active'] == 'on') ? 1 : 0
                );
                $query_update->execute();

                $album_id_insert_image = $form_data['id_edit'];
                $success = $lang_module['success_alb_update'];
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die();
            }
        }
    }

    // insert image path:
    if ($album_id_insert_image && $form_data['image']) {
        try {
            $query_insert_image = $db_connect->insertImage(
                time() . "-" . str_replace("/uploads/photo-album/", "", $form_data['image']),
                $form_data['image'],
                ($form_data['highlight']) ? 1 : 0,
                $album_id_insert_image,
                1
            );
            $query_insert_image->execute();
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
// hiển thị form:
$list_cate = $db_connect->getAll('tbl_cates')->fetchAll();
$list_subcate = $db_connect->getAll('tbl_subcates')->fetchAll();
$subcate_option = '<option value="0">-- none --</option>';
$form_data['highlight'] = 'checked';
$form_data['active'] = 'checked';

// show sửa:
if ($get_data['id_edit'] > 0) {
    $album_edit = $db_connect->getBy("tbl_albums", "id = " . $get_data['id_edit'])->fetch();
    $image_re = $db_connect->getBy("tbl_images", "album_id = " . $get_data['id_edit'], ["order_by" => "id DESC"])->fetch();

    if ($form_data = $album_edit) {
        $form_data['active'] = ($album_edit['active'] == 1) ? 'checked' : '';
        $form_data['image'] = $image_re['path'];
    } else { // valid:
        $error = $lang_module['valid_empty'];
    }
}

// ajax change cate -> subcate:
if ($nv_Request->isset_request('change_cate', 'get')) {
    $cate_id = $nv_Request->get_int('cate_id', 'get', 0);

    if ($cate_id > 0) {
        $query_select = $db_connect->getBy("tbl_subcates", "cate_id = " . $cate_id);
        while ($subcate = $query_select->fetch()) {
            $html_cate .= '<option value="' . $subcate['id'] . '">' . $subcate['name'] . '</option>';
        }
        die($html_cate); // response
    } else {
        die('<option value="0">-- none --</option>');
    }
}

// show editor:
if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$form_data['content'] = htmlspecialchars(nv_editor_br2nl($form_data['content']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $form_data['content'] = nv_aleditor('content', '100%', '200px', $form_data['content']);
} else {
    $form_data['content'] = '<textarea name="content" style="width:100%;height:200px">' . $form_data['content'] . '</textarea>';
}

//------------------------------
// Gọi teamplate và đổ DL
//------------------------------
$xtpl = new XTemplate('update-album.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_CHECK_SESSION', NV_CHECK_SESSION);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_name);
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

if ($list_cate) {
    $html_cate = '<option value="0">' . $lang_module['default_cate_option'] . '</option>';

    foreach ($list_cate as $key => $cate) {
        $selected = ($cate['id'] == $form_data['cate_id']) ? 'selected' : '';
        $html_cate .= '<option ' . $selected . ' value="' . $cate['id'] . '">' . $cate['name'] . '</option>';
        $xtpl->assign('CATE_OPTION', $html_cate);
        $xtpl->parse('main.loop-cate');
    }
}

if ($get_data['id_edit'] > 0 && $album_edit) {
    foreach ($list_subcate as $key => $subcate) {
        $selected = ($subcate['id'] == $form_data['subcate_id']) ? 'selected' : '';
        $html_subcate .= '<option ' . $selected . ' value="' . $subcate['id'] . '">' . $subcate['name'] . '</option>';
        $xtpl->assign('SUBCATE_OPTION', $html_subcate);
        $xtpl->parse('main.loop-cate');
    }
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
