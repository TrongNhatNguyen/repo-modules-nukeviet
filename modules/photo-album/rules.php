<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

class Rules
{
    private $error = "";
    private $lang_module;
    private $query_builder;
    private $tb_albums;
    private $tb_images;
    function __construct()
    {
        global $lang_module;

        $this->lang_module = $lang_module;
        $this->query_builder = new QueryBuilder();
        $this->tb_albums = $this->query_builder->tb_albums;
        $this->tb_images = $this->query_builder->tb_images;
    }

    //========================================
    // INSERT RULES
    //========================================
    function insAlbumRules(array $fields)
    {
        if (!$fields['title']) {
            $this->error = $this->lang_module['valid_alb_requi_title'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_alb_requi_alias'];
        }
        elseif (!$fields['description']) {
            $this->error = $this->lang_module['valid_alb_requi_desc'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }
        // check exist:
        elseif ($this->query_builder->getBy($this->tb_albums, "title LIKE '" . $fields['title'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_alb_exist_title'];
        }
        elseif ($this->query_builder->getBy($this->tb_albums, "alias LIKE '" . $fields['alias'] . "'")->fetch()) {
            $this->error = $this->lang_module['valid_alb_exist_alias'];
        }
        // elseif ($this->query_builder->getBy($this->tb_albums, "feature_image_path LIKE '" . $fields['feature_image_path'] ."'")->fetch()) {
        //     $this->error = $this->lang_module['valid_alb_exist_image_path'];
        // }
        
        return $this->error;
    }

    //========================================
    // UPDATE RULES
    //========================================
    function updAlbumRules(array $fields)
    {
        if (!($this->query_builder->getBy($this->tb_albums, "id = '" . $fields['id'] . "'")->fetch())) {
            $this->error = $this->lang_module['valid_empty'];
        }
        elseif (!$fields['title']) {
            $this->error = $this->lang_module['valid_alb_requi_title'];
        }
        elseif (!$fields['alias']) {
            $this->error = $this->lang_module['valid_alb_requi_alias'];
        }
        elseif (!$fields['description']) {
            $this->error = $this->lang_module['valid_alb_requi_desc'];
        }
        elseif ($valid_alias = $this->convertSlug($fields['alias'])) {
            $this->error = $valid_alias;
        }

        return $this->error;
    }

    //========================================
    // DELETE RULES
    //========================================
    function delAlbumRules($id_del)
    {
        $child_albums = $this->query_builder->getBy($this->tb_albums, "parent_id = '" . $id_del . "'")->fetchAll();
        if (count($child_albums) > 0) {
            $this->error = $this->lang_module['valid_exist_child_alb'];
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
