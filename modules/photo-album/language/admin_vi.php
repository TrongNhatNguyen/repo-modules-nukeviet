<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'hugonhatnguyen (nguyentrongnhat230600@gmail.com)';
$lang_translator['createdate'] = '30/08/2021, 9:30';
$lang_translator['copyright'] = '@Copyright (C) 2012 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';
//-----------------------------

$lang_module['add'] = 'Danh sách Album ảnh'; // // ở các func ở block, submenu MAIN
$lang_module['album_content'] = 'Thêm Album ảnh mới';
$lang_module['album_content_update'] = 'Cập nhật Album ảnh';
$lang_module['image_list'] = 'Kho ảnh Album';
$lang_module['album_image_title'] = 'Cập nhật kho ảnh Album: ';

// --- option mặc định:
$lang_module['def_parent_option'] = '-- không phụ thuộc Album nào --';

//=== alert
// icon:
$icon_inf = '<i class="fa fa-info fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_err = '<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_succ = '<i class="fa fa-check fa-lg" aria-hidden="true"></i>&nbsp; ';

$lang_module['valid_empty'] = $icon_err . 'Dữ liệu không tồn tại.';
$lang_module['valid_alias'] = $icon_err . 'Liên kết tĩnh không hợp lệ.';
$lang_module['notify_empty'] = $icon_inf . 'Không có danh sách nào gửi đến bạn!';

//--- valid:
$lang_module['valid_alb_requi_title'] = $icon_err . 'Vui lòng nhập tiêu đề Album.';
$lang_module['valid_alb_requi_alias'] = $icon_err . 'Vui lòng nhập liên kết Album.';
$lang_module['valid_alb_requi_desc'] = $icon_err . 'Vui lòng nhập mô tả Album.';
$lang_module['valid_alb_exist_title'] = $icon_err . 'Tiêu đề Album đã tồn tại.';
$lang_module['valid_alb_exist_alias'] = $icon_err . 'Liên kết Album đã tồn tại.';
$lang_module['valid_alb_exist_image_path'] = $icon_err . 'Ảnh đại diện đã tồn tại.';
$lang_module['valid_exist_child_alb'] = 'Không thể xoá do có chứa Album ảnh phụ thuộc.';

$lang_module['success_image_create'] = $icon_succ . 'Đã thêm 1 ảnh mới vào Album.';
$lang_module['success_alb_create'] = $icon_succ . 'Đã thêm Album ảnh mới.';
$lang_module['success_alb_update'] = $icon_succ . 'Đã Cập nhật Album ảnh thành công.';

//----------[ in file.tpl ]-------------------------------
//--- table:
$lang_module['zoom_in'] = 'Phóng to';
$lang_module['zoom_out'] = 'Thu nhỏ';
// tb-albums
$lang_module['stt'] = 'STT';
$lang_module['active'] = 'Hiển Thị';
$lang_module['created_at'] = 'Ngày Tạo';
$lang_module['updated_at'] = 'Cập Nhật';
$lang_module['action'] = 'Thao Tác';
$lang_module['edit'] = 'Sửa';
$lang_module['edit_palb_title'] = 'Thay đổi Album gốc';
$lang_module['edit_title'] = 'Sửa Album này';
$lang_module['image_update'] = 'Cập nhật kho ảnh Album này';
$lang_module['remove'] = 'Xoá';
// tb-image:
$lang_module['image'] = 'Hình ảnh';
$lang_module['image_name'] = 'Tên hình ảnh';
$lang_module['highlight'] = 'Nổi bật';

//--- form submit:
// tb-album:
$lang_module['title'] = 'Tiêu đề';
$lang_module['alias'] = 'Liên kết tĩnh';
$lang_module['image'] = 'Hình ảnh';
$lang_module['parent_album'] = 'Album gốc';
$lang_module['feature_image_path'] = 'Ảnh đại diện';
$lang_module['description'] = 'Mô tả';
$lang_module['content'] = 'Nội dung chi tiết';
$lang_module['active'] = 'Hiển thị';
$lang_module['submit'] = 'Lưu Lại';
// image:

// --- thông báo xoá:
$lang_module['sweet_alert_title'] = 'Bạn Chắc Chứ?';
$lang_module['sweet_alert_text'] = 'Bạn không thể phục hồi điều này!';
$lang_module['sweet_alert_confirm_btn'] = 'Xoá Luôn!';
$lang_module['sweet_alert_cancel_btn'] = 'Huỷ Bỏ';
$lang_module['sweet_fire_title_success'] = 'Thành Công!';
$lang_module['sweet_fire_title_error'] = 'Thất Bại!';
$lang_module['sweet_fire_text'] = 'Dữ liệu đã được xoá.';
