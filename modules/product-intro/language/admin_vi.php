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
$lang_translator['createdate'] = '10/09/2021, 9:30';
$lang_translator['copyright'] = '@Copyright (C) 2012 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';
//-----------------------------

$lang_module['add'] = 'Danh sách sản phẩm';
$lang_module['cate_list'] = 'Danh mục sản phẩm';
$lang_module['prod_content'] = 'Thêm mới sản phẩm';
$lang_module['prod_content_update'] = 'Cập nhật sản phẩm';
$lang_module['image_list'] = 'Cập nhật hình ảnh sản phẩm';
$lang_module['slider_list'] = 'Cập nhật sliders sản phẩm';

// --- option mặc định:
$lang_module['def_parent_cate_option'] = '-- Là danh mục cha --';
$lang_module['def_cate_search_option'] = '-- Tất cả các danh mục --';
$lang_module['def_status_search_option'] = '-- Trạng thái --';

//=== alert
// icon:
$icon_inf = '<i class="fa fa-info fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_err = '<i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>&nbsp; ';
$icon_succ = '<i class="fa fa-check fa-lg" aria-hidden="true"></i>&nbsp; ';

//===== valid:
$lang_module['valid_empty'] = $icon_err . 'Dữ liệu không tồn tại.';
$lang_module['notify_empty'] = $icon_inf . 'Không có danh sách nào gửi đến bạn!';
$lang_module['valid_alias'] = $icon_err . 'Liên kết tĩnh không hợp lệ.';
$lang_module['valid_requi_alias'] = $icon_err . 'Vui lòng nhập liên kết tĩnh.';
$lang_module['valid_exist_alias'] = $icon_err . 'Liên kết tĩnh đã tồn tại.';

// cate
$lang_module['valid_cate_requi_name'] = $icon_err . 'Vui lòng nhập tên danh mục.';
$lang_module['valid_cate_exist_name'] = $icon_err . 'Tên danh mục đã tồn tại.';
$lang_module['valid_exist_child_cate'] = 'Không thể xoá do có chứa danh mục con.';
$lang_module['success_image_create'] = $icon_succ . 'Đã thêm 1 ảnh mới vào Sản phẩm.';
$lang_module['success_cate_create'] = $icon_succ . 'Đã thêm danh mục mới.';
$lang_module['success_cate_update'] = $icon_succ . 'Đã cập nhật danh mục thành công.';

// products:
$lang_module['valid_prod_requi_name'] = $icon_err . 'Vui lòng nhập tên sản phẩm.';
$lang_module['valid_prod_exist_name'] = $icon_err . 'Tên sản phẩm đã tồn tại.';
$lang_module['valid_prod_requi_price'] = $icon_err . 'Vui lòng nhập giá sản phẩm.';
$lang_module['valid_prod_requi_desc'] = $icon_err . 'Vui lòng nhập mô tả sản phẩm.';
$lang_module['success_prod_create'] = $icon_succ . 'Đã thêm sản phẩm mới.';
$lang_module['success_prod_update'] = $icon_succ . 'Đã cập nhật sản phẩm thành công.';

// images:
$lang_module['success_image_create'] = $icon_succ . 'Đã thêm ảnh sản phẩm mới.';
$lang_module['success_image_update'] = $icon_succ . 'Đã cập nhật ảnh sản phẩm thành công.';

// sliders:
$lang_module['success_slider_create'] = $icon_succ . 'Đã thêm slider sản phẩm mới.';
$lang_module['success_slider_update'] = $icon_succ . 'Đã cập nhật slider sản phẩm thành công.';
//----------[ in file.tpl ]-------------------------------
//===== table:
$lang_module['all'] = '-- Tất Cả --';
$lang_module['zoom_in'] = 'Phóng to';
$lang_module['zoom_out'] = 'Thu nhỏ';
$lang_module['status'] = 'Trang Thái';
$lang_module['active'] = 'Hoạt Động';
$lang_module['deactive'] = 'Dừng Hoạt Động';
// tb-cates:
$lang_module['list_cate'] = 'Danh sách danh mục';
$lang_module['stt'] = 'STT';
$lang_module['created_at'] = 'Ngày Tạo';
$lang_module['updated_at'] = 'Cập Nhật';
$lang_module['action'] = 'Thao Tác';
$lang_module['edit'] = 'Sửa';
$lang_module['edit_pcate_title'] = 'Thay đổi danh mục cha';
$lang_module['edit_title'] = 'Sửa danh mục này';
$lang_module['remove'] = 'Xoá';
//tb-products:
$lang_module['prod_name'] = 'Tên sản phẩm';
$lang_module['price'] = 'Giá sản phẩm';
$lang_module['description'] = 'Mô tả sản phẩm';
$lang_module['edit_prod_title'] = 'Sửa sản phẩm này';
// tb-image:
$lang_module['prod_image_title'] = "Cập nhật kho ảnh sản phẩm:";
$lang_module['image'] = 'Hình ảnh';
$lang_module['image_name'] = 'Tên hình ảnh';
$lang_module['highlight'] = 'Nổi bật';
$lang_module['image_update'] = 'Cập nhật hình ảnh';
// tb-slider:
$lang_module['prod_slider_title'] = 'Cập nhật sliders sản phẩm:';
//===== form submit:
$lang_module['search'] = 'Tìm kiếm';
$lang_module['alias'] = 'Liên kết tĩnh';
$lang_module['submit'] = 'Lưu Lại';
$lang_module['perform'] = 'Thực Hiện';
// tb-cate:
$lang_module['cate_name'] = 'Tên danh mục';
$lang_module['create_cate'] = 'Thêm mới danh mục';
$lang_module['update_cate'] = 'Cập nhật danh mục';
$lang_module['parent_cate'] = 'Danh mục cha';
//tb-product:
$lang_module['currency'] = ['VNĐ', 'USD'];
$lang_module['feature_image_path'] = 'Ảnh đại diện';
$lang_module['content'] = 'Nội dung chính';
// image:

// --- thông báo xoá:
$lang_module['sweet_alert_title'] = 'Bạn Chắc Chứ?';
$lang_module['sweet_alert_text'] = 'Bạn không thể phục hồi điều này!';
$lang_module['sweet_alert_confirm_btn'] = 'Xoá Luôn!';
$lang_module['sweet_alert_cancel_btn'] = 'Huỷ Bỏ';
$lang_module['sweet_fire_title_success'] = 'Thành Công!';
$lang_module['sweet_fire_title_error'] = 'Thất Bại!';
$lang_module['sweet_fire_title_info'] = 'Thông báo!';
$lang_module['sweet_fire_text_del'] = 'Dữ liệu đã được xoá.';
$lang_module['sweet_fire_text_upd'] = 'Dữ liệu đã được cập nhật.';
$lang_module['sweet_fire_checkbox_text'] = 'Vui lòng tick chọn sản phẩm.';
