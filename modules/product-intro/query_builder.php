<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

class QueryBuilder
{
    public $tb_cates = 'tbl_cates';
    public $tb_products = 'tbl_products';
    public $tb_images = 'tbl_images';
    public $tb_sliders = 'tbl_sliders';

    private $db;
    private $sql;
    private $name_prefix_lang_module;
    
    function __construct()
    {
        global $db, $module_data;

        $this->db = $db;
        $this->name_prefix_lang_module = NV_PREFIXLANG . "_" . $module_data . "_";
    }

    //=============
    // GLOBAL FUNC
    //=============
    function getAll(string $table_name, array $args_sql = null)
    {
        $default = [
            "field_get" => "*",
            "active" => null,
            "order_by" => "id DESC",
            "limit" => null,
            "offset" => 0,
        ];

        $args_sql = ($args_sql) ? array_merge($default, $args_sql) : $default;

        $this->db->sqlreset()->select($args_sql['field_get'])->from($this->name_prefix_lang_module . $table_name);
        if ($args_sql['active']) {$this->db->where("active = " . $args_sql['active']);}
        if ($args_sql['order_by']) {$this->db->order($args_sql['order_by']);}
        if ($args_sql['limit']) {$this->db->limit($args_sql['limit']);}
        if ($args_sql['offset']) {$this->db->offset($args_sql['offset']);}

        $this->sql = $this->db->sql();
        return $this->db->query($this->sql);
    }

    function getBy(string $table_name, string $field_set, array $args_sql = null)
    {
        $default = [
            "field_get" => "*",
            "active" => null,
            "order_by" => "id DESC",
            "limit" => null,
            "offset" => 0,
        ];

        $args_sql = ($args_sql) ? array_merge($default, $args_sql) : $default;
        $active_sql = ($args_sql['active']) ? " AND (active = " . $args_sql['active'] . ")" : "";

        $this->db->sqlreset()->select($args_sql['field_get'])->from($this->name_prefix_lang_module . $table_name);
        $this->db->where("(" . $field_set . ")" . $active_sql);
        if ($args_sql['order_by']) {$this->db->order($args_sql['order_by']);}
        if ($args_sql['limit']) {$this->db->limit($args_sql['limit']);}
        if ($args_sql['offset']) {$this->db->offset($args_sql['offset']);}

        $this->sql = $this->db->sql();
        return $this->db->query($this->sql);
    }

    function countNumRows($table_name, string $field_set = null)
    {
        try {
            $this->sql = "SELECT COUNT(*) FROM `" . $this->name_prefix_lang_module . $table_name . "`";
            if ($field_set) {$this->sql .= "WHERE (" . $field_set . ");";}

            return $this->db->query($this->sql)->fetchColumn();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }

    function getLastRows($table_name, $field_get = "*")
    {
        try {
            $this->sql = "SELECT " . $field_get . " FROM `" . $this->name_prefix_lang_module . $table_name . "`
                          ORDER BY `id` DESC LIMIT 1;";
        return $this->db->query($this->sql);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }

    function updateWeight($table_name, int $id_edit, int $weight)
    {
        $this->sql = "UPDATE`" . $this->name_prefix_lang_module . $table_name . "` SET
                        `weight`=:weight WHERE `id` = " . $id_edit . ";";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('weight', $weight);
        return $stmt;
    }

    function updateActive($table_name, int $id_edit, int $active)
    {
        $this->sql = "UPDATE`" . $this->name_prefix_lang_module . $table_name . "`
                      SET `active`=:active, `updated_at`=:updated_at WHERE `id` = " . $id_edit . ";";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', NV_CURRENTTIME);
        return $stmt;
    }

    function updateHighlight($table_name, int $id_edit, int $highlight)
    {
        $this->sql = "UPDATE`" . $this->name_prefix_lang_module . $table_name . "`
                      SET `highlight`=:highlight, `updated_at`=:updated_at WHERE `id` = " . $id_edit . ";";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('highlight', $highlight);
        $stmt->bindValue('updated_at', NV_CURRENTTIME);
        return $stmt;
    }


    //=============
    // INSERT FUNC
    //=============
    function insertCate(int $parent_id, $name, $alias, $active = 0)
    {
        $num_rows = $this->countNumRows($this->tb_cates);
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_cates . "` (
                        `parent_id`,
                        `name`,
                        `alias`,
                        `active`,
                        `weight`,
                        `created_at`
                    )
                    VALUES (:parent_id, :name, :alias, :active, :weight, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('parent_id', $parent_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('weight', $num_rows + 1);
        $stmt->bindValue('created_at', NV_CURRENTTIME);
        return $stmt;
    }

    function insertProduct(int $cate_id, $name, $alias, $price, $feature_image_path = null, $description, $content = null, $active = 0)
    {
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_products . "` (
                        `cate_id`,
                        `name`,
                        `alias`,
                        `price`,
                        `feature_image_path`,
                        `description`,
                        `content`,
                        `active`,
                        `weight`,
                        `created_at`
                    )
                    VALUES (:cate_id, :name, :alias, :price, :feature_image_path, :description, :content, :active, :weight, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('cate_id', $cate_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('price', $price);
        $stmt->bindParam('feature_image_path', $feature_image_path);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('content', $content);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('weight', 0);
        $stmt->bindValue('created_at', NV_CURRENTTIME);
        return $stmt;
    }

    function insertImage(int $product_id, $name, $path, $highlight = 0, $active = 0)
    {
        $num_rows = $this->countNumRows($this->tb_images, "product_id = " . $product_id);
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_images . "` (
                        `product_id`,
                        `name`,
                        `path`,
                        `highlight`,
                        `active`,
                        `weight`,
                        `created_at`
                    )
                    VALUES (:product_id, :name, :path, :highlight, :active, :weight, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('product_id', $product_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('path', $path);
        $stmt->bindValue('highlight', $highlight);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('weight', $num_rows + 1);
        $stmt->bindValue('created_at', NV_CURRENTTIME);
        return $stmt;
    }

    function insertSlider(int $product_id, $name, $path, $highlight = 0, $active = 0)
    {
        $num_rows = $this->countNumRows($this->tb_sliders, "product_id = " . $product_id);
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_sliders . "` (
                        `product_id`,
                        `name`,
                        `path`,
                        `highlight`,
                        `active`,
                        `weight`,
                        `created_at`
                    )
                    VALUES (:product_id, :name, :path, :highlight, :active, :weight, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('product_id', $product_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('path', $path);
        $stmt->bindValue('highlight', $highlight);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('weight', $num_rows + 1);
        $stmt->bindValue('created_at', NV_CURRENTTIME);
        return $stmt;
    }

    // //=============
    // // UPDATE FUNC
    // //=============
    function updateCate(int $id_edit, int $parent_id, $name, $alias, $active = 0)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_cates . "` SET
                        `parent_id`=:parent_id,
                        `name`=:name,
                        `alias`=:alias,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('parent_id', $parent_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', NV_CURRENTTIME);
        return $stmt;
    }

    function updateProduct(int $id_edit, int $cate_id, $name, $alias, $price, $feature_image_path = null, $description, $content = null, $active = 0)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_products . "` SET
                        `cate_id`=:cate_id,
                        `name`=:name,
                        `alias`=:alias,
                        `price`=:price,
                        `feature_image_path`=:feature_image_path,
                        `description`=:description,
                        `content`=:content,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindValue('cate_id', $cate_id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('price', $price);
        $stmt->bindParam('feature_image_path', $feature_image_path);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('content', $content);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', NV_CURRENTTIME);
        return $stmt;
    }

    //=============
    // DELETE FUNC
    //=============
    function delCate($id)
    {
        try {
            $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_cates . "`
                      WHERE `id` = " . $id . ";";
            return $this->db->query($this->sql);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }

    function delProduct($id)
    {
        try {
            $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_products . "`
                      WHERE `id` = " . $id . ";";
            return $this->db->query($this->sql);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }

    function delImage($id)
    {
        try {
            $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_images . "`
                      WHERE `id` = " . $id . ";";
            return $this->db->query($this->sql);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }

    function delSlider($id)
    {
        try {
            $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_sliders . "`
                      WHERE `id` = " . $id . ";";
            return $this->db->query($this->sql);
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die;
        }
    }
}
