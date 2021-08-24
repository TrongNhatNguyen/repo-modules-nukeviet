<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 7-17-2010 14:43
 */

class DBConnect
{
    private $db;
    private $sql;
    private $name_prefix_lang_module;
    private $tb_ablum;
    private $tb_image;
    private $tb_cate;
    private $tb_subcate;
    
    function __construct()
    {
        global $db, $module_data;

        $this->db = $db;
        $this->name_prefix_lang_module = NV_PREFIXLANG . "_" . $module_data . "_";
        $this->tb_ablum = 'tbl_albums';
        $this->tb_image = 'tbl_images';
        $this->tb_cate = 'tbl_cates';
        $this->tb_subcate = 'tbl_subcates';
    }


    function getAll(string $table_name, array $args_sql = null)
    {
        $default = [
            "field_get" => "*",
            "avtive" => null,
            "order_by" => "weight DESC",
            "limit" => null,
            "offset" => 0,
        ];

        $args_sql = ($args_sql) ? array_merge($default, $args_sql) : $default;

        $this->db->sqlreset()->select($args_sql['field_get'])->from($this->name_prefix_lang_module . $table_name);
        if ($args_sql['active']) {$this->db->where("active = " . $args_sql['active']);}
        $this->db->order($args_sql['order_by'])->limit($args_sql['limit'])->offset($args_sql['offset']);

        $this->sql = $this->db->sql();
        return $this->db->query($this->sql);
    }

    function getBy(string $table_name, string $field_set, array $args_sql = null)
    {
        $default = [
            "field_get" => "*",
            "active" => null,
            "order_by" => "weight DESC",
            "limit" => null,
            "offset" => 0,
        ];

        $args_sql = ($args_sql) ? array_merge($default, $args_sql) : $default;
        $active_sql = ($args_sql['active']) ? " AND (active = " . $args_sql['active'] . ")" : "";

        $this->db->sqlreset()->select($args_sql['field_get'])->from($this->name_prefix_lang_module . $table_name);
        $this->db->where("(" . $field_set . ")" . $active_sql);
        $this->db->order($args_sql['order_by'])->limit($args_sql['limit'])->offset($args_sql['offset']);

        $this->sql = $this->db->sql();
        return $this->db->query($this->sql);
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

    function countNumRows($table_name, string $field_set = null)
    {
        try {
            $this->sql = "SELECT COUNT(*) FROM `" . $this->name_prefix_lang_module . $table_name . "`";
            if ($field_set) {$this->sql .= "WHERE (" . $field_set . ");";}

            return $this->db->query($this->sql)->fetchColumn();
        } catch (\PDOException $ex) {
            print_r($ex->getMessage());
            die();
        }
    }

    //========================================
    // ALBUM TABLE connect
    //========================================
    //--insert
    function insertAlbum($name, $alias, $description = null, $cate_id, $subcate_id, $active = 0, $created_at = NV_CURRENTTIME)
    {
        $last_row = $this->getLastRows($this->tb_ablum)->fetch();
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_ablum . "` (
                        `id`,
                        `name`,
                        `alias`,
                        `description`,
                        `cate_id`,
                        `subcate_id`,
                        `weight`,
                        `active`,
                        `created_at`
                    )
                    VALUES (NULL, :name, :alias, :description, :cate_id, :subcate_id, :weight, :active, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindParam('description', $description);
        $stmt->bindValue('cate_id', $cate_id);
        $stmt->bindValue('subcate_id', $subcate_id);
        $stmt->bindValue('weight', $last_row['weight'] + 1);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('created_at', $created_at);
        return $stmt;
    }

    //--update
    function updateAlbum($id_edit, $name, $alias, $description = null, $cate_id, $subcate_id, $active = 0, $updated_at = NV_CURRENTTIME)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_ablum . "` SET
                        `name`=:name,
                        `alias`=:alias,
                        `description`=:description,
                        `cate_id`=:cate_id,
                        `subcate_id`=:subcate_id,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindParam('description', $description);
        $stmt->bindValue('cate_id', $cate_id);
        $stmt->bindValue('subcate_id', $subcate_id);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', $updated_at);
        return $stmt;
    }

    //-- del
    function delAlbum($id)
    {
        $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_ablum . "`
                      WHERE `id` = " . $id . ";";
        return $this->db->query($this->sql);
    }

    //========================================
    // IMAGE TABLE connect
    //========================================
    function insertImage($name, $path, $album_id, $active = 0, $created_at = NV_CURRENTTIME)
    {
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_image . "` (
                        `id`,
                        `name`,
                        `path`,
                        `album_id`,
                        `active`,
                        `created_at`
                    )
                    VALUES (NULL, :name, :path, :album_id, :active, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('path', $path);
        $stmt->bindValue('album_id', $album_id);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('created_at', $created_at);
        return $stmt;
    }

    //--update
    function updateImage($id_edit, $name, $path, $album_id, $active = 0, $updated_at = NV_CURRENTTIME)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_image . "` SET
                        `name`=:name,
                        `path`=:path,
                        `album_id`=:album_id,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('path', $path);
        $stmt->bindValue('album_id', $album_id);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', $updated_at);
        return $stmt;
    }

    //-- del
    function delImage($id)
    {
        $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_image . "`
                      WHERE `id` = " . $id . ";";
        return $this->db->query($this->sql);
    }

    //========================================
    // CATEGORIES TABLE connect
    //========================================
    //-- insert:
    function insertCate($name, $alias, $active = 0, $created_at = NV_CURRENTTIME)
    {
        $last_row = $this->getLastRows($this->tb_cate)->fetch();
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_cate . "` (
                        `id`,
                        `name`,
                        `alias`,
                        `weight`,
                        `active`,
                        `created_at`
                    )
                    VALUES (NULL, :name, :alias, :weight, :active, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('weight', $last_row['weight'] + 1);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('created_at', $created_at);
        return $stmt;
    }

    //--update
    function updateCate($id_edit, $name, $alias, $active = 0, $updated_at = NV_CURRENTTIME)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_cate . "` SET
                        `name`=:name,
                        `alias`=:alias,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', $updated_at);
        return $stmt;
    }

    //-- del
    function delCate($id)
    {
        $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_cate . "`
                      WHERE `id` = " . $id . ";";
        return $this->db->query($this->sql);
    }

    //========================================
    // SUBCATEGORIES TABLE connect
    //========================================
    //-- insert:
    function insertSubcate($name, $alias, $cate_id, $active = 0, $created_at = NV_CURRENTTIME)
    {
        $last_row = $this->getLastRows($this->tb_subcate)->fetch();
        
        $this->sql = "INSERT INTO `" . $this->name_prefix_lang_module . $this->tb_subcate . "` (
                        `id`,
                        `name`,
                        `alias`,
                        `cate_id`,
                        `weight`,
                        `active`,
                        `created_at`
                    )
                    VALUES (NULL, :name, :alias, :cate_id, :weight, :active, :created_at);";
        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('cate_id', $cate_id);
        $stmt->bindValue('weight', $last_row['weight'] + 1);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('created_at', $created_at);
        return $stmt;
    }

    //--update
    function updateSubcate($id_edit, $name, $alias, $cate_id, $active = 0, $updated_at = NV_CURRENTTIME)
    {
        $this->sql = "UPDATE `" . $this->name_prefix_lang_module . $this->tb_subcate . "` SET
                        `name`=:name,
                        `alias`=:alias,
                        `cate_id`=:cate_id,
                        `active`=:active,
                        `updated_at`=:updated_at
                    WHERE `id` = " . $id_edit . ";";

        $stmt = $this->db->prepare($this->sql);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('alias', $alias);
        $stmt->bindValue('cate_id', $cate_id);
        $stmt->bindValue('active', $active);
        $stmt->bindValue('updated_at', $updated_at);
        return $stmt;
    }

    //-- del
    function delSubcate($id)
    {
        $this->sql = "DELETE FROM `" . $this->name_prefix_lang_module . $this->tb_subcate . "`
                      WHERE `id` = " . $id . ";";
        return $this->db->query($this->sql);
    }
}
?>
