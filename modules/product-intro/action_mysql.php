<?php
 
/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 10/09/2021 09:50
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

// tên table:
$tb_cates = 'tbl_cates';
$tb_products = 'tbl_products';
$tb_images = 'tbl_images';
$tb_sliders = 'tbl_sliders';


$sql_drop_module = array();

// Câu lệnh tạo tên các bảng:
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_cates . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_products . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . ";";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_sliders . ";";
 
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_cates . " (
`id` int(4) NOT NULL AUTO_INCREMENT,
`parent_id` int(4) NOT NULL DEFAULT '0',
`name` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`active` tinyint(2) NOT NULL DEFAULT '1',
`weight` int(11) NOT NULL DEFAULT '0',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
UNIQUE KEY `alias` (`alias`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_products . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`cate_id` int(4) NOT NULL,
`name` varchar(255) NOT NULL,
`alias` varchar(255) NOT NULL,
`price` decimal(10,0) NULL DEFAULT '0',
`feature_image_path` varchar(255) null DEFAULT '/uploads/" . $module_name . "/no-image.webp',
`description` text NOT NULL,
`content` text NULL,
`active` tinyint(2) NOT NULL DEFAULT '1',
`weight` int(11) NOT NULL DEFAULT '0',
`created_at` int(11) NOT NULL DEFAULT '0',
`updated_at` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`),
UNIQUE KEY `alias` (`alias`),
KEY `cate_id` (`cate_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . " (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL DEFAULT '0',
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
KEY `product_id` (`product_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_sliders . " (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL DEFAULT '0',
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
KEY `product_id` (`product_id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8";

//
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_cates . " (`parent_id`, `name`, `alias`, `active`, `weight`, `created_at`, `updated_at`) VALUES
(0, 'Túi Xách', 'tui-xach', 1, 1, 20210910, 0),
(1, 'Túi Xách Nữ', 'tui-xach-nu', 1, 2, 20210910, 0),
(1, 'Túi Xách Nam', 'tui-xach-nam', 1, 3, 20210910, 20210910),
(1, 'Túi Xách Thời Trang', 'tui-xach-thoi-trang', 1, 4, 20210910, 20210910),
(1, 'Túi Xách Da Thật', 'tui-xach-thoi-da-that', 1, 5, 20210910, 20210910),
(0, 'Giày Dép', 'giay-dep', 1, 6, 20210910, 20210910),
(6, 'Giày Da Nam', 'giay-da-nam', 1, 7, 20210910, 20210910),
(6, 'Giày Nữ', 'giay-nu', 1, 8, 20210910, 20210910),
(6, 'Sandal Nữ', 'sandal-nu', 1, 9, 20210910, 20210910),
(6, 'Dép Nam', 'dep-nam', 1, 10, 20210910, 20210910);
";

// $sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_products . " (`cate_id`, `name`, `alias`, `price`, `feature_image_path`, `description`, `content`, `active`, `weight`, `created_at`, `updated_at`) VALUES
// (2, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL98', 'tui-xach-nu-thoi-trang-cao-cap-elly-el98', '784000', '/uploads/" . $module_name . "/feature_image/Tui-xach-nu-thoi-trang-cao-cap.jpg', '– Thương hiệu: ELLY.\r\n– Sản xuất: Việt Nam, Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).\r\n– Màu sắc: Xanh\r\n– Kích thước: 18 x 18 x 8 cm (chiều ngang x chiều dọc x độ dày).\r\n– Chất liệu: Da tổng hợp cao cấp nhập khẩu bóng đẹp, chống thấm tốt, chống bám bụi, bền bỉ với thời gian. Từng đường may mũi chỉ tinh tế, đều nhau trên bề mặt da giúp tăng sự bền đẹp của sản phẩm.\r\n– Bảo hành: 03 tháng (với lỗi do sản xuất).', 'Ai bảo rằng túi xách là một khối hình chữ nhật? Chúng có thể mang bất kỳ hình dạng nào, miễn rằng có đủ không gian để các tín đồ đựng những vật dụng cá nhân của mình. Bằng nhiều cách khác nhau, các nhà thiết kếELLY luôn không ngừng sáng tạo, thử sức với cái mới nhằm mang đến nét độc đáo cho bộ sưu tập của mình. Để tạo sự khác biệt, các thiết kế đã phá vỡ quy luật, tạo nên những chiếc túi xách có kiểu dáng tròn thật độc lạ như ELLY – EL98. Hãy cùng khám phá ngay vẻ đẹp độc đáo, cá tính nhưng cũng không kém phần nữ tính của chiếc túi xách cực HOT này ngay bây giờ nàng nhé!\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg', 1, 1, 160251, 20210910),
// (2, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL99', 'tui-xach-nu-thoi-trang-cao-cap-elly-el99', '784000', '/uploads/" . $module_name . "/feature_image/Tui-xach-nu-thoi-trang-cao-cap.jpg', '– Thương hiệu: ELLY.\r\n– Sản xuất: Việt Nam, Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).\r\n– Màu sắc: Xanh\r\n– Kích thước: 18 x 18 x 8 cm (chiều ngang x chiều dọc x độ dày).\r\n– Chất liệu: Da tổng hợp cao cấp nhập khẩu bóng đẹp, chống thấm tốt, chống bám bụi, bền bỉ với thời gian. Từng đường may mũi chỉ tinh tế, đều nhau trên bề mặt da giúp tăng sự bền đẹp của sản phẩm.\r\n– Bảo hành: 03 tháng (với lỗi do sản xuất).', 'Ai bảo rằng túi xách là một khối hình chữ nhật? Chúng có thể mang bất kỳ hình dạng nào, miễn rằng có đủ không gian để các tín đồ đựng những vật dụng cá nhân của mình. Bằng nhiều cách khác nhau, các nhà thiết kếELLY luôn không ngừng sáng tạo, thử sức với cái mới nhằm mang đến nét độc đáo cho bộ sưu tập của mình. Để tạo sự khác biệt, các thiết kế đã phá vỡ quy luật, tạo nên những chiếc túi xách có kiểu dáng tròn thật độc lạ như ELLY – EL98. Hãy cùng khám phá ngay vẻ đẹp độc đáo, cá tính nhưng cũng không kém phần nữ tính của chiếc túi xách cực HOT này ngay bây giờ nàng nhé!\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg', 1, 2, 160251, 20210910),
// (2, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL100', 'tui-xach-nu-thoi-trang-cao-cap-elly-el100', '784000', '/uploads/" . $module_name . "/feature_image/Tui-xach-nu-thoi-trang-cao-cap.jpg', '– Thương hiệu: ELLY.\r\n– Sản xuất: Việt Nam, Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).\r\n– Màu sắc: Xanh\r\n– Kích thước: 18 x 18 x 8 cm (chiều ngang x chiều dọc x độ dày).\r\n– Chất liệu: Da tổng hợp cao cấp nhập khẩu bóng đẹp, chống thấm tốt, chống bám bụi, bền bỉ với thời gian. Từng đường may mũi chỉ tinh tế, đều nhau trên bề mặt da giúp tăng sự bền đẹp của sản phẩm.\r\n– Bảo hành: 03 tháng (với lỗi do sản xuất).', 'Ai bảo rằng túi xách là một khối hình chữ nhật? Chúng có thể mang bất kỳ hình dạng nào, miễn rằng có đủ không gian để các tín đồ đựng những vật dụng cá nhân của mình. Bằng nhiều cách khác nhau, các nhà thiết kếELLY luôn không ngừng sáng tạo, thử sức với cái mới nhằm mang đến nét độc đáo cho bộ sưu tập của mình. Để tạo sự khác biệt, các thiết kế đã phá vỡ quy luật, tạo nên những chiếc túi xách có kiểu dáng tròn thật độc lạ như ELLY – EL98. Hãy cùng khám phá ngay vẻ đẹp độc đáo, cá tính nhưng cũng không kém phần nữ tính của chiếc túi xách cực HOT này ngay bây giờ nàng nhé!\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg', 1, 3, 160251, 20210910),
// (2, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL901', 'tui-xach-nu-thoi-trang-cao-cap-elly-el101', '784000', '/uploads/" . $module_name . "/feature_image/Tui-xach-nu-thoi-trang-cao-cap.jpg', '– Thương hiệu: ELLY.\r\n– Sản xuất: Việt Nam, Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).\r\n– Màu sắc: Xanh\r\n– Kích thước: 18 x 18 x 8 cm (chiều ngang x chiều dọc x độ dày).\r\n– Chất liệu: Da tổng hợp cao cấp nhập khẩu bóng đẹp, chống thấm tốt, chống bám bụi, bền bỉ với thời gian. Từng đường may mũi chỉ tinh tế, đều nhau trên bề mặt da giúp tăng sự bền đẹp của sản phẩm.\r\n– Bảo hành: 03 tháng (với lỗi do sản xuất).', 'Ai bảo rằng túi xách là một khối hình chữ nhật? Chúng có thể mang bất kỳ hình dạng nào, miễn rằng có đủ không gian để các tín đồ đựng những vật dụng cá nhân của mình. Bằng nhiều cách khác nhau, các nhà thiết kếELLY luôn không ngừng sáng tạo, thử sức với cái mới nhằm mang đến nét độc đáo cho bộ sưu tập của mình. Để tạo sự khác biệt, các thiết kế đã phá vỡ quy luật, tạo nên những chiếc túi xách có kiểu dáng tròn thật độc lạ như ELLY – EL98. Hãy cùng khám phá ngay vẻ đẹp độc đáo, cá tính nhưng cũng không kém phần nữ tính của chiếc túi xách cực HOT này ngay bây giờ nàng nhé!\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg\r\nhttps://cdn.elly.vn/uploads/2018/06/14075511/Tui-xach-nu-thoi-trang-cao-cap-ELLY-EL98-4-1.jpg', 1, 4, 160251, 20210910);
// ";
