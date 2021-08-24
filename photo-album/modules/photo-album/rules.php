<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18/08/2021 09:50
 */

class Rules
{
    private $lang_module;
    private $db_connect;
    function __construct()
    {
        global $lang_module;

        $this->db_connect = new DBConnect();
        $this->lang_module = $lang_module;
    }


    //========================================
    // valid form insert album
    //========================================
    function insAlbumRules(array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['valid_alb_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['valid_alb_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }
        // check exist
        elseif ($this->db_connect->getBy("tbl_albums", "name LIKE '" . $fields['name'] . "'")->fetch()) {
            $error = $this->lang_module['valid_alb_exist_name'];
        }
        elseif ($this->db_connect->getBy("tbl_albums", "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $error = $this->lang_module['valid_alb_exist_alias'];
        }
        elseif (!$fields['cate_id']) {
            $error = $this->lang_module['valid_alb_requi_cate'];
        }
        elseif (!$fields['subcate_id']) {
            $error = $this->lang_module['valid_alb_requi_subcate'];
        }
        
        return $error;
    }

    function updAlbumRules(array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['vailid_alb_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['vailid_alb_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }
        elseif (!$fields['cate_id']) {
            $error = $this->lang_module['vailid_alb_requi_cate'];
        }
        elseif (!$fields['subcate_id']) {
            $error = $this->lang_module['vailid_alb_requi_subcate'];
        }

        return $error;
    }

    //========================================
    // valid form insert image
    //========================================
    function insImageRules($fields)
    {
        if ($this->db_connect->getBy("tbl_images", "path LIKE '" . $fields . "'", ["order_by" => "id DESC"])->fetch()) {
            $error = $this->lang_module['valid_image_exist_name'];
        }
    }

    //========================================
    // valid form insert Cate
    //========================================
    function insCateRules(array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['valid_cate_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }
        // check exist
        elseif ($this->db_connect->getBy("tbl_cates", "name LIKE '" . $fields['name'] . "'")->fetch()) {
            $error = $this->lang_module['valid_cate_exist_name'];
        }
        elseif ($this->db_connect->getBy("tbl_cates", "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $error = $this->lang_module['valid_cate_exist_alias'];
        }

        return $error;
    }

    function updCateRules(array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['valid_cate_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }

        return $error;
    }

    //========================================
    // valid form insert Subcate
    //========================================
    function insSubcateRules (array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['valid_cate_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }
        // check exist
        elseif ($this->db_connect->getBy("tbl_subcates", "name LIKE '" . $fields['name'] . "'")->fetch()) {
            $error = $this->lang_module['valid_cate_exist_name'];
        }
        elseif ($this->db_connect->getBy("tbl_subcates", "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $error = $this->lang_module['valid_cate_exist_alias'];
        }
        elseif (!$fields['cate_id']) {
            $error = $this->lang_module['valid_alb_requi_cate'];
        }

        return $error;
    }

    function updSubcateRules(array $fields)
    {
        if (!$fields['name']) {
            $error = $this->lang_module['valid_cate_requi_name'];
        }
        elseif (!$fields['alias']) {
            $error = $this->lang_module['valid_cate_requi_alias'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $error = $valid_alias;
        }
        elseif (!$fields['cate_id']) {
            $error = $this->lang_module['valid_alb_requi_cate'];
        }

        return $error;
    }

    ///-- basic func:
    function convertSlug($text)
    {
        if(!preg_match('/^[a-z][-a-z0-9]*$/', $text)){
            return $this->lang_module['vailid_alias'];
        }
    }
}
