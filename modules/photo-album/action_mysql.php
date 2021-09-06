<?php
 
/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

// tên table:
$tb_albums = 'tbl_albums';
$tb_images = 'tbl_images';


$sql_drop_module = array();

// Câu lệnh tạo tên các bảng:
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_albums . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . ";";
 
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_albums . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`parent_id` int(11) NOT NULL DEFAULT '0',
`title` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`feature_image_path` varchar(255) null DEFAULT '/uploads/" . $module_name . "/no-image.webp',
`description` text NOT NULL,
`content` text NULL,
`active` tinyint(2) NOT NULL DEFAULT '1',
`weight` int(11) NOT NULL DEFAULT '0',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `title` (`title`),
UNIQUE KEY `alias` (`alias`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . " (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
`album_id` int(11) NOT NULL DEFAULT '0',
`name` varchar(255) NOT NULL,
`path` varchar(255) NOT NULL,
`highlight` tinyint(1) NOT NULL DEFAULT '0',
`active` tinyint(2) NOT NULL DEFAULT '1',
`weight` int(11) NOT NULL DEFAULT '0',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
KEY `path` (`path`),
KEY `album_id` (`album_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_albums . " (`id`, `parent_id`, `title`, `alias`, `feature_image_path`, `description`, `content`, `active`, `weight`, `created_at`, `updated_at`)
VALUES
(1, 0, 'Phong Cảnh Đà Lạt', 'phong-canh-da-lat', '/uploads/" . $module_name . "/feature-image/canh-da-lat.jpg', 'Chiêm ngưỡng những phong cảnh tuyệt vời chốn bồng lai ở Đà lạt, khu du lịch nổi tiếng của Việt Nam.', 'Đến với Đà Lạt, mọi người đều ngỡ ngàng với những khung cảnh đẹp tựa chốn thần tiên, nơi đây còn có nhiều khu danh lam thắng cảnh được UNESSCO công nhận, du khách có thể lưu dữ những bức ảnh cực đẹp với bạn bè và gia đình.', 1, 1, 94732, 0),
(2, 0, 'Ngày Hội Nhà Trường', 'ngay-hoi-nha-truong', '/uploads/" . $module_name . "/no-image.png', 'Album ảnh về ngày hội tưng bừng của trường THPT Tân Phú, lưu giữ kỷ niệm nhà trường.', 'Chào đón không khí hân hoan của ngày hội trường THPT Tân Phú với muôn vàn cảm xúc xen lẫn các hoạt động mang nhiều thông điệp ý nghĩa, lưu giữ những bức ảnh về các hoạt động sự kiện nổi bật của trường.', 1, 2, 93930, 0),
(3, 2, 'Hội Thao Mùa Xuân', 'hoi-thao-mua-xuan', '/uploads/" . $module_name . "/feature-image/hoi-thao-mua-xuan.jpg', 'Album ảnh về ngày hội mùa xuân tưng bừng của trường THPT Tân Phú, lưu giữ kỷ niệm nhà trường.', 'Chào đón không khí hân hoan của ngày hội thao mùa xuân trường THPT Tân Phú với muôn vàn cảm xúc xen lẫn các hoạt động mang nhiều thông điệp ý nghĩa, lưu giữ những bức ảnh về các hoạt động sự kiện nổi bật của trường.', 0, 3, 94553, 1630466196),
(4, 2, 'Sinh Hoạt hè', 'sinh-hoat-he', '/uploads/" . $module_name . "/feature-image/hoat-dong-he.jpg', 'Album ảnh về ngày sinh hoạt hè cực kỳ vui nhộn tưng bừng của trường THPT Tân Phú, lưu giữ kỷ niệm nhà trường. Tất cả thầy cô trường Tân Phú đã sẵn sàng “lên dây cót” tinh thần và tăng tốc triển khai hình thức hoạt động thực tế cho năm học mới.', 'Chào đón không khí hân hoan của buổi sinh hoạt hè cực kỳ vui nhộn trường THPT Tân Phú với muôn vàn cảm xúc xen lẫn các hoạt động mang nhiều thông điệp ý nghĩa, lưu giữ những bức ảnh về các hoạt động sự kiện nổi bật của trường dựa trên tinh thần tinh thần và tăng tốc triển khai hình thức hoạt động thực tế cho năm học mới.', 1, 4, 95349, 0);";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . " (`id`, `album_id`, `name`, `path`, `highlight`, `active`, `weight`, `created_at`, `updated_at`)
VALUES
(1, 1, '1630658996-canh-da-lat.jpg', '/uploads/" . $module_name . "/images/1/canh-da-lat.jpg', 1, 1, 1, 1630658996, 0),
(2, 1, '1630659072-ho-thanh-tai-phia-nam-da-lat.jpg', '/uploads/" . $module_name . "/images/1/ho-thanh-tai-phia-nam-da-lat.jpg', 1, 1, 2, 1630659072, 0),
(3, 1, '1630659094-du-lich-da-lat-danh-cho-gia-dinh.jpg', '/uploads/" . $module_name . "/images/1/du-lich-da-lat-danh-cho-gia-dinh.jpg', 0, 1, 3, 1630659094, 0),
(4, 1, '1630659109-vuon-thuong-uyen-bay-1-wfrc.jpg', '/uploads/" . $module_name . "/images/1/vuon-thuong-uyen-bay-1-wfrc.jpg', 0, 1, 4, 1630659109, 0),
(5, 1, '1630659118-vuon-hoa-sac-mau.jpg', '/uploads/" . $module_name . "/images/1/vuon-hoa-sac-mau.jpg', 0, 1, 5, 1630659118, 0),
(6, 1, '1630659128-ban-do-khu-du-lich-da-lat.jpg', '/uploads/" . $module_name . "/images/1/ban-do-khu-du-lich-da-lat.jpg', 0, 1, 6, 1630659128, 0),
(7, 3, '1630659326-le-hoi-mua-xuan-noi-bat-o-thanh-pho.jpg', '/uploads/" . $module_name . "/images/3/le-hoi-mua-xuan-noi-bat-o-thanh-pho.jpg', 1, 1, 1, 1630659326, 0),
(8, 3, '1630659339-vnp_hoi_hoa_xuan_ecopark_2019.jpg', '/uploads/" . $module_name . "/images/3/vnp_hoi_hoa_xuan_ecopark_2019.jpg', 0, 1, 2, 1630659339, 0),
(9, 3, '1630659354-hoi-hoa-xuan.jpg', '/uploads/" . $module_name . "/images/3/hoi-hoa-xuan.jpg', 1, 1, 3, 1630659354, 0),
(10, 3, '1630659368-vna_potal_khai_mac_hoi_hoa_xuan.jpg', '/uploads/" . $module_name . "/images/3/vna_potal_khai_mac_hoi_hoa_xuan.jpg', 0, 1, 4, 1630659368, 0),
(11, 4, '1630659789-hoi-ngay-he-tung-bung.jpg', '/uploads/" . $module_name . "/images/4/hoi-ngay-he-tung-bung.jpg', 1, 1, 1, 1630659789, 0),
(12, 4, '1630659800-tro-choi-ngay-he.jpg', '/uploads/" . $module_name . "/images/4/tro-choi-ngay-he.jpg', 0, 1, 2, 1630659800, 0),
(13, 4, '1630659804-sinh-hoat-he-truong-cap-2.jpg', '/uploads/" . $module_name . "/images/4/sinh-hoat-he-truong-cap-2.jpg', 0, 1, 3, 1630659804, 0),
(14, 4, '1630659808-hoat-dong-he.jpg', '/uploads/" . $module_name . "/images/4/hoat-dong-he.jpg', 1, 1, 4, 1630659808, 0),
(15, 2, '1630660090-tro-choi-ngay-he.jpg', '/uploads/" . $module_name . "/images/2/tro-choi-ngay-he.jpg', 1, 1, 1, 1630660090, 0),
(16, 2, '1630660091-n-a', '/uploads/" . $module_name . "/no-image.png', 0, 1, 2, 1630660091, 0);";
