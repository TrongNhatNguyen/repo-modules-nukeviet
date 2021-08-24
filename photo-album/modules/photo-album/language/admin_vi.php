<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'hugonhatnguyen (nguyentrongnhat230600@gmail.com)';
$lang_translator['createdate'] = '18/08/2021, 9:30';
$lang_translator['copyright'] = '@Copyright (C) 2012 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';
//-----------------------------

$lang_module['add'] = 'Danh sách album'; // // ở các func ở block, submenu MAIN
$lang_module['update_album_sub'] = 'Thêm album mới';
$lang_module['update_album'] = 'Cập nhật danh sách album';

$lang_module['list_cate'] = 'Danh sách Chuyên mục';

$lang_module['list_subcate'] = 'Danh sách chuyên mục thành phần';

//--- table:
$lang_module['stt'] = 'STT';
$lang_module['active'] = 'Hiện';
$lang_module['active_0'] = 'Ẩn';
$lang_module['active_1'] = 'Hiện';
$lang_module['created_at'] = 'Ngày Tạo';
$lang_module['updated_at'] = 'Cập Nhật';
$lang_module['action'] = 'Thao Tác';
$lang_module['edit'] = 'Sửa';
$lang_module['remove'] = 'Xoá';

//--- form submit:
$lang_module['default_cate_option'] = '-- Chọn chuyên mục --';
$lang_module['name'] = 'Tiêu đề';
$lang_module['alias'] = 'Liên kết tĩnh';
$lang_module['image'] = 'Hình ảnh';
$lang_module['description'] = 'Nội dung chi tiết';
$lang_module['cate'] = 'Chuyên mục gốc';
$lang_module['subcate'] = 'Chuyên mục thành phần';
$lang_module['active'] = 'Hiển thị';
$lang_module['submit'] = 'Lưu Lại';

//--- alert
// icon error:
$icon_inf = '<i class="fa fa-info fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_err = '<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_succ = '<i class="fa fa-check fa-lg" aria-hidden="true"></i>&nbsp; ';
$lang_module['valid_empty'] = $icon_err . 'Dữ liệu không tồn tại.';
$lang_module['valid_alias'] = $icon_err . 'URL không hợp lệ.';

$lang_module['notify_empty'] = $icon_inf . 'Không có danh sách nào gửi đến bạn!';

$lang_module['valid_alb_requi_name'] = $icon_err . 'Vui lòng nhập tiêu đề album.';
$lang_module['valid_alb_requi_alias'] = $icon_err . 'Vui lòng nhập URL album.';
$lang_module['valid_alb_requi_cate'] = $icon_err . 'Chuyên mục không hợp lệ.';
$lang_module['valid_alb_requi_subcate'] = $icon_err . 'Chuyên mục con không hợp lệ.';
$lang_module['valid_alb_exist_name'] = $icon_err . 'Tiêu đề album đã tồn tại.';
$lang_module['valid_alb_exist_alias'] = $icon_err . 'URL album đã tồn tại.';
$lang_module['success_alb_create'] = $icon_succ . 'Đã thêm alubm ảnh mới.';
$lang_module['success_alb_update'] = $icon_succ . 'Đã Cập nhật album ảnh thành công.';

$lang_module['valid_cate_requi_name'] = $icon_err . 'Vui lòng nhập tiêu đề chuyên mục.';
$lang_module['valid_cate_requi_alias'] = $icon_err . 'Vui lòng nhập URL chuyên mục.';
$lang_module['valid_cate_exist_name'] = $icon_err . 'Tiêu đề chuyên mục đã tồn tại.';
$lang_module['valid_cate_exist_alias'] = $icon_err . 'URL chuyên mục đã tồn tại.';
$lang_module['success_cate_create'] = $icon_succ . 'Đã thêm chuyên mục mới.';
$lang_module['success_cate_update'] = $icon_succ . 'Đã Cập nhật chuyên mục thành công.';

$lang_module['valid_image_exist_name'] = $icon_err . 'Hình ảnh này mục đã tồn tại.';
