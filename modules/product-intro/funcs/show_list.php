<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_IS_MOD_PRODUCT_INTRO')) {
    die('Stop!!!');
}
$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

//------------------------------------------
// Viết code xử lý chung vào đây
//------------------------------------------
$helper = new Helper();
$query_builder = new QueryBuilder();
$tb_cates = $query_builder->tb_cates;
$tb_products = $query_builder->tb_products;
$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

// lấy dl từ url:
$search_data = [
    'text_search' => $nv_Request->get_title('text_search', 'get', ''),
    'cate_id' => (int) $nv_Request->get_int('cate_id', 'get', 0),
    //
    'search_act' => $nv_Request->get_title('search_act', 'get', '')
];


//=========[ show ]=======================
// phân trang:
$perpage = 9;
$page = (int) $nv_Request->get_int('page', 'get', 1);
$totals = $query_builder->countNumRows($tb_products);

// hiển thị tất cả sản phẩm:
try {
    // xử lí tìm kiếm:
    if (!empty($search_data['search_act']) && $search_data['search_act'] == 'true') {
        // search tên:
        $field_set = ($search_data['text_search']) ? "name LIKE '%" . $search_data['text_search']. "%'" : "name LIKE '%%'";
        
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

        $query_select = $query_builder->getBy($tb_products, $field_set, ["limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    } else {
        $query_select = $query_builder->getAll($tb_products, ['active' => 1, "limit" => $perpage, "offset" => ($page - 1) * $perpage]);
    }
    
    $list_product = [];
    while ($product = $query_select->fetch()) {
        $product['url_detail'] = nv_url_rewrite($base_url . "detail/" . $product['alias'] . "-" . $product['id'] . $global_config['rewrite_exturl']);
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        
        $product['created_at'] = gmdate("d-m-Y\ H:i:s", $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $product['updated_at']) : '';

        $list_product[$product['id']] = $product;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

// hiển thị 5 sản phẩm mới nhất:
try {
    $query_select = $query_builder->getAll($tb_products, ['active' => 1, "limit" => 5]);
    $list_new_product = [];
    while ($product = $query_select->fetch()) {
        $product['url_detail'] = nv_url_rewrite($base_url . "detail/" . $product['alias'] . "-" . $product['id'] . $global_config['rewrite_exturl']);
        $product['price'] = number_format($product['price'], 0, '', ',');
        $product['active'] = ($product['active'] == 1) ? 'checked' : '';
        
        $product['created_at'] = gmdate("d-m-Y\ H:i:s", $product['created_at']);
        $product['updated_at'] = ($product['updated_at'] != 0) ? gmdate("d-m-Y\ H:i:s", $product['updated_at']) : '';

        $list_new_product[$product['id']] = $product;
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

// hiển thị danh mục cho search:
try {
    $list_cate = $query_builder->getAll($tb_cates, ['active' => 1])->fetchAll();
    $cate_option = '<option value="0">' . $lang_module['def_cate_search_option'] . '</option>';
    if (!empty($list_cate) && count($list_cate) > 0) {
        $cate_option .= $helper->rowsRecusive($list_cate, $search_data['cate_id']);
    }
} catch (\PDOException $ex) {
    print_r($ex->getMessage());
    die;
}

//---------------------------------------------
// Gọi file themes và đổ DL
//---------------------------------------------
//----[ Thêm vào tiêu đề - SEO ]
$page_title = $lang_module['add'];
$key_words = $module_info['keywords'];

//----[ breadcrumb ]
$array_mod_title[] = array(
    'title' => $lang_module['show_list'],
    'link' => nv_url_rewrite($base_url . $op, true)
);

//----[ paginate ]
$paginate = [
    'perpage' => $perpage,
    'page' => $page,
    'totals' => $totals,
];

$contents = nv_theme_product_intro_show_list($list_product, $list_new_product, $search_data, $cate_option, $paginate);

// bắt buộc hiển thị:
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
