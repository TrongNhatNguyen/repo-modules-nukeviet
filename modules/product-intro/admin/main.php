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
$page_title = $lang_module['add'];

//------------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------------
$get_data = array();
$search_data = array();
$search_data = array();
$search_data = array();
$multiple_data = array();
$error = "";
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

$helper = new Helper();
$rules = new Rules();
$query_builder = new QueryBuilder();
$tb_cates = $query_builder->tb_cates;
$tb_products = $query_builder->tb_products;
$tb_images = $query_builder->tb_images;
$tb_sliders = $query_builder->tb_sliders;

// lấy dl từ url:
$get_data['id'] = (int) $nv_Request->get_int('id', 'get', 0);
$get_data['checksess'] = $nv_Request->get_title('checksess', 'get', '');

$search_data = [
    'text_search' => $nv_Request->get_title('text_search', 'get', ''),
    'cate_id' => (int) $nv_Request->get_int('cate_id', 'get', 0),
    'status' => $nv_Request->get_title('status', 'get', 'all'),
    'perpage' => (int) $nv_Request->get_int('perpage', 'get', 6),
    //
    'search_act' => $nv_Request->get_title('search_act', 'get', '')
];

$multiple_data = [
    'check_list' => $nv_Request->get_array('check_list', 'post', ''),
    'multiple_action' => $nv_Request->get_title('multiple_action', 'post', '')
];
//===================================
// xử lí submit multiple action:
if (!empty($multiple_data['multiple_action']) && array_filter($multiple_data['check_list']) != []) {
    // chọn xoá:
    if ($multiple_data['multiple_action'] == 'del') {
        foreach ($multiple_data['check_list'] as $key => $id) {
            // valid:
            $error = $rules->delProductRules($id);

            if (empty($error)) {
                $product_del = $query_builder->getBy($tb_products, "id = " . $id)->fetch();
    
                // xoá:
                $query_builder->delProduct($id);
    
                // xoá kho image của product:
                // $query_select = $query_builder->getBy($tb_images, "product_id = " . $id);
                // while ($image_del = $query_select->fetch()) {
                //     $query_builder->delImage($image_del['id']);
                // }
    
                // cập nhật lại weight:
                try {
                    $list_behind = $query_builder->getBy($tb_products, "weight > " . $product_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
                    $new_weight = $product_del['weight'];
                    foreach ($list_behind as $key => $behind) {
                        $query_update_new_weight = $query_builder->updateWeight($tb_products, $behind['id'], $new_weight);
                        $query_update_new_weight->execute();
                        $new_weight ++;
                    }
                } catch (\PDOException $ex) {
                    print_r($ex->getMessage());
                    die;
                }
            } else {
                die($error); // phản hồi ajax.
            }
        };

        die;
    }

    // chọn ngưng hoạt động:
    if ($multiple_data['multiple_action'] == 'deactive') {
        foreach ($multiple_data['check_list'] as $key => $id) {
            try {
                $prod = $query_builder->getBy($tb_products, "id = " . $id)->fetch();
                if (!empty($prod) && $prod['active'] == 1) {
                    $query_update_active = $query_builder->updateActive($tb_products, $id, 0);
                    $query_update_active->execute();
                }
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        };
        
        die;
    };

    // chọn hoạt động:
    if ($multiple_data['multiple_action'] == 'active') {
        foreach ($multiple_data['check_list'] as $key => $id) {
            try {
                $prod = $query_builder->getBy($tb_products, "id = " . $id)->fetch();
                if (!empty($prod) && $prod['active'] == 0) {
                    $query_update_active = $query_builder->updateActive($tb_products, $id, 1);
                    $query_update_active->execute();
                }
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        };
        
        die;
    };
}

// thay đổi thứ tự (weight):
if($get_data['id'] > 0 && $nv_Request->isset_request('change_weight', 'get')) {
    $new_weight = (int) $nv_Request->get_int('new_weight', 'get', 0);
    
    if ($new_weight > 0) {
        $query_select = $query_builder->getBy($tb_products, "id != " . $get_data['id'], ['field_get' => 'id, weight', "order_by" => "weight ASC"]);
        
        $weight = 0;
        while ($list_product = $query_select->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            // cập nhật các weight còn lại
            try {
                $query_update_weight = $query_builder->updateWeight($tb_products, $list_product['id'], $weight);
                $query_update_weight->execute();
            } catch (\PDOException $ex) {
                print_r($ex->getMessage());
                die;
            }
        }
        // cập nhật weight đang chọn
        try {
            $query_update_new_weight = $query_builder->updateWeight($tb_products, $get_data['id'], $new_weight);
            $query_update_new_weight->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// thay đổi trạng thái (active):
if($get_data['id'] > 0 && $nv_Request->isset_request('change_active', 'get')) {
    $new_status = (int) $nv_Request->get_int('new_status', 'get', 0);

    if ($new_status == 0 || $new_status == 1) {
        try {
            $query_update_active = $query_builder->updateActive($tb_products, $get_data['id'], $new_status);
            $query_update_active->execute();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}

// xoá product:
if ($nv_Request->isset_request('action_del', 'get')) {
    if ($get_data['id'] > 0 && md5($get_data['id'] . NV_CHECK_SESSION) == md5($get_data['checksess'])) {
        // valid:
        $error = $rules->delProductRules($get_data['id']);

        if (empty($error)) {
            $product_del = $query_builder->getBy($tb_products, "id = " . $get_data['id'])->fetch();

            // xoá:
            $query_builder->delProduct($get_data['id']);

            // xoá kho image của sp:
            $query_select = $query_builder->getBy($tb_images, "product_id = " . $get_data['id']);
            while ($image_del = $query_select->fetch()) {
                $query_builder->delImage($image_del['id']);
            }

            // xoá kho slider của sp:
            $query_select = $query_builder->getBy($tb_sliders, "product_id = " . $get_data['id']);
            while ($slider_del = $query_select->fetch()) {
                $query_builder->delSlider($slider_del['id']);
            }

            // cập nhật lại weight:
            try {
                $list_behind = $query_builder->getBy($tb_products, "weight > " . $product_del['weight'], ["order_by" => "weight ASC"])->fetchAll();
                $new_weight = $product_del['weight'];
                foreach ($list_behind as $key => $behind) {
                    $query_update_new_weight = $query_builder->updateWeight($tb_products, $behind['id'], $new_weight);
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


//=========[ show ]==================
// khai báo mặc định:
$List_multiple_act = [
    'del' => $lang_module['remove'],
    'deactive' => $lang_module['deactive'],
    'active' => $lang_module['active']
];
$list_cate = $query_builder->getAll($tb_cates, ['order_by' => 'id DESC', 'active' => 1])->fetchAll();
$list_status = [
    'all' => $lang_module['def_status_search_option'],
    '1' => $lang_module['deactive'],
    '2' => $lang_module['active'],
];
$list_perpage = [6, 10, 25, 50, 100];

// phân trang:
$perpage = 6;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $query_builder->countNumRows($tb_products);
if ($totals <= (($page - 1) * $perpage)) {
    $page = (ceil($totals/$perpage) > 0) ? ceil($totals/$perpage) : 1;
}

// show bảng danh sách sản phẩm:
try {
    // xử lí tìm kiếm:
    if (!empty($search_data['search_act']) && $search_data['search_act'] == 'true') {
        // search tên:
        $field_set = ($search_data['text_search']) ? "name LIKE '%" . $search_data['text_search']. "%'" : "name LIKE '%%'";
        
        // search trạng thái:
        $field_set .= ($search_data['status'] == 'all') ? "" : " AND active = " . ((int) $search_data['status'] - 1);
        
        // search theo danh mục:
        if ($search_data['cate_id'] > 0) {
            // lấy sp theo danh mục đang chọn:
            $cate = $query_builder->getBy($tb_cates, "id = " . $search_data['cate_id'])->fetch();
            $field_set .= " AND (cate_id = " . $cate['id'];

            // lấy sp theo danh mục CON của danh mục đang chọn:
            $query_select = $query_builder->getBy($tb_cates, "parent_id = " . $search_data['cate_id']);
            while ($child_cate = $query_select->fetch()) {
                $field_set .= " OR cate_id = " . $child_cate['id'];
            }

            $field_set .= ")";
        }

        $query_select = $query_builder->getBy($tb_products, $field_set, ["order_by" => "id ASC", "limit" => $search_data['perpage'], "offset" => ($page - 1) * $search_data['perpage']]);
    } else {
        // mặc định hiển thị danh sách
        $query_select = $query_builder->getAll($tb_products, ["order_by" => "id ASC", "limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    }
    
    while ($product = $query_select->fetch()) {
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        $product['created_at'] = date('d-m-Y\ H:i A', $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? date("d-m-Y\ H:i A", $product['updated_at']) : '';

        $list_product[$product['id']] = $product;
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
$xtpl->assign('OP', $op);
$xtpl->assign('PAGE', $page);


//--> show form tìm kiếm:
// danh mục
if (!empty($list_cate) && count($list_cate) > 0) {
    $cate_option = '<option value="0">' . $lang_module['def_cate_search_option'] . '</option>';
    $cate_option .= $helper->rowsRecusive($list_cate, $search_data['cate_id']);
    $xtpl->assign('CATE_OPTION', $cate_option);
    $xtpl->parse('main.cate_option');
}

// trang thái:
if (!empty($list_status)) {
$status_option = '';
    foreach ($list_status as $key => $status) {
        $selected = ($key == $search_data['status']) ? 'selected' : '';
        $status_option .= '<option ' . $selected . ' value="' . $key . '">' . $status . '</option>';
    }
    $xtpl->assign('STATUS_OPTION', $status_option);
    $xtpl->parse('main.status_option');
}

// limit:
if (!empty($list_perpage)) {
    $perpage_option = '';
    foreach ($list_perpage as $key => $num_rows) {
        $selected = ($search_data['perpage'] == $num_rows) ? 'selected' : '';
        $perpage_option .= '<option ' . $selected . ' value="' . $num_rows . '">' . $num_rows . '</option>';
    }
    $xtpl->assign('PERPAGE_OPTION', $perpage_option);
    $xtpl->parse('main.perpage_option');
}
//------<

// show bảng danh sách sản phẩm:
if (!empty($list_product) && count($list_product) > 0) {

    foreach ($list_product as $key => $product) {
        $product['url_action'] = $base_url . $op;
        $product['url_edit'] = $base_url . "product_content&amp;id=" . $product['id'];
        $product['url_image_update'] = $base_url . "image_list&amp;product_id=" . $product['id'];
        $product['url_slider_update'] = $base_url . "slider_list&amp;product_id=" . $product['id'];
        $xtpl->assign('PROD', $product);
        $xtpl->parse('main.loop');
    }

    // multiple action:
    if ($List_multiple_act) {
        $mult_option = '';
        foreach ($List_multiple_act as $key => $multiple_act) {
            $selected = ($multiple_data['multiple_action'] == $key) ? 'selected' : '';
            $mult_option .= '<option ' . $selected . ' value="' . $key . '">' . $multiple_act . '</option>';
            $xtpl->assign('MULTIPLE_OPTION', $mult_option);
        }
    }
    $xtpl->parse('main.multiple_action');

    // phân trang:
    if ($perpage < $totals) {
        $paginate = nv_generate_page($base_url . $op, $totals, $perpage, $page);
        $paginate_html = '<div class="clearfix pull-right">' . $paginate . '</div><div class="clearfix"></div>';
        $xtpl->assign('PAGINATE', $paginate_html);
    }
} else {
    $notify_empty = '<div class="alert alert-info" role="alert">' . $lang_module['notify_empty'] . '</div>';
    $xtpl->assign('NOTIFY_EMPTY', $notify_empty);
    $xtpl->parse('main.notify');
}

// mặc định:
$xtpl->assign('SEARCH_DATA', $search_data);

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
