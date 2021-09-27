<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

class Rules
{
    private $error = "";
    private $lang_module;
    private $query_builder;
    private $tb_cates;
    private $tb_products;
    function __construct()
    {
        global $lang_module;

        $this->lang_module = $lang_module;
        $this->query_builder = new QueryBuilder();
        $this->tb_cates = $this->query_builder->tb_cates;
        $this->tb_products = $this->query_builder->tb_products;
    }

    //========================================
    // INSERT RULES
    //========================================
    function insCateRules(array $fields)
    {
        if (!$fields['name']) {
            $this->error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }
        // check exist:
        elseif ($this->query_builder->getBy($this->tb_cates, "name LIKE '" . $fields['name'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_cate_exist_name'];
        }
        elseif ($this->query_builder->getBy($this->tb_cates, "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_exist_alias'];
        }
        
        return $this->error;
    }

    function insProductRules(array $fields)
    {
        if (!$fields['name']) {
            $this->error = $this->lang_module['valid_prod_requi_name'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_requi_alias'];
        }
        elseif (!$fields['price']) {
            $this->error = $this->lang_module['valid_prod_requi_price'];
        }
        elseif (!$fields['description']) {
            $this->error = $this->lang_module['valid_prod_requi_desc'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }
        // check exist:
        elseif ($this->query_builder->getBy($this->tb_products, "name LIKE '" . $fields['name'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_prod_exist_name'];
        }
        elseif ($this->query_builder->getBy($this->tb_products, "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_exist_alias'];
        }
        // elseif ($this->query_builder->getBy($this->tb_products, "feature_image_path LIKE '" . $fields['feature_image_path'] ."'")->fetch()) {
        //     $this->error = $this->lang_module['valid_prod_exist_image_path'];
        // }
        
        return $this->error;
    }

    //========================================
    // UPDATE RULES
    //========================================
    function updCateRules(array $fields)
    {
        if (!($this->query_builder->getBy($this->tb_cates, "id = '" . $fields['id'] . "'")->fetch())) {
            $this->error = $this->lang_module['valid_empty'];
        }
        elseif (!$fields['name']) {
            $this->error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }

        return $this->error;
    }

    function updProductRules(array $fields)
    {
        if (!($this->query_builder->getBy($this->tb_products, "id = '" . $fields['id'] . "'")->fetch())) {
            $this->error = $this->lang_module['valid_empty'];
        }
        elseif (!$fields['name']) {
            $this->error = $this->lang_module['valid_name_requi_name'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_requi_alias'];
        }
        elseif (!$fields['price']) {
            $this->error = $this->lang_module['valid_prod_requi_price'];
        }
        elseif (!$fields['description']) {
            $this->error = $this->lang_module['valid_prod_requi_desc'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }

        return $this->error;
    }

    //========================================
    // DELETE RULES
    //========================================
    function delCateRules($id_del)
    {
        $child_cates = $this->query_builder->getBy($this->tb_cates, "parent_id = " . $id_del)->fetchAll();
        if (count($child_cates) > 0) {
            $this->error = $this->lang_module['valid_exist_child_cate'];
        }

        return $this->error;
    }

    function delProductRules($id_del)
    {
        $product_del = $this->query_builder->getBy($this->tb_products, "id = " . $id_del)->fetchAll();
        if (empty($product_del)) {
            $this->error = $this->lang_module['valid_empty'];
        }

        return $this->error;
    }
    

    ///=== BASIC FUNC:
    function convertSlug($text)
    {
        if(!preg_match('/^[a-z][-a-z0-9]*$/', $text)){
            return $this->lang_module['vailid_alias'];
        }
    }
}
