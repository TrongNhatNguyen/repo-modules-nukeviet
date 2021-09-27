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

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_products . " (`cate_id`, `name`, `alias`, `price`, `feature_image_path`, `description`, `content`, `active`, `weight`, `created_at`, `updated_at`) VALUES
(3, 'TÚI CLUTCH NAM DA THẬT ELLY HOMME – ECM1', 'tui-clutch-nam-da-that-elly-homme-ecm1', '1079000', '/uploads/product-intro/feature_image/tui-clutch-nam-cao-cap-da-that-elly-ecm1-13-300x300.jpg', '<p><strong>– Thương hiệu: </strong>ELLY HOMME.<br />\r\n<strong>– Sản xuất:</strong> Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).<br />\r\n<strong>– Màu sắc:</strong>&nbsp;Đen.<br />\r\n<strong>– Kích thước:</strong>&nbsp;26 x 17 x 0,5 cm (Chiều ngang x chiều dọc x độ dày).<br />\r\n<strong>– Chất liệu</strong>: Da thật cao cấp nhập khẩu.<br />\r\n<strong>– Kiểu dáng:</strong>&nbsp;Clutch cầm tay.<br />\r\n<strong>– Trọn bộ sản phẩm gồm:</strong> Túi clutch nam da thật ELLY HOMME – ECM1 + Hộp + Túi vải sang trọng.<br />\r\n<strong>– Bảo hành:</strong>&nbsp;06 tháng (với lỗi do sản xuất)</p>', '<strong><a href=\"http://elly.vn/tui-xach\">Túi xách</a>&nbsp;không chỉ đơn thuần là một món phụ kiện để đựng đồ đạc mà còn là tuyên ngôn cá tính, là thước đo sự sành điệu và đôi khi còn là người bạn đồng hành “trung thành” tuyệt đối của con gái. Hãy thử thay đổi phong cách, biến mình trở thành một cô gái sành điệu, trẻ trung bằng cách bổ sung cho bộ sưu tập túi của mình chiếc&nbsp;<a href=\"http://elly.vn/tui-xach/tui-xach-thoi-trang-cao-cap\">Túi xách nam cao cấp</a>&nbsp;HOMME – ECM1 ngay bây giờ nhé!</strong>', 1, 0, 1632706784, 0),
(2, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL98', 'tui-xach-nu-thoi-trang-cao-cap-elly-el98', '784000', '/uploads/product-intro/feature_image/tui-xach-nu-thoi-trang-cao-cap-elly-el98-12-2-300x300.jpg', '<p><strong>– Thương hiệu: </strong>ELLY.<br />\r\n<strong>– Sản xuất</strong>: Việt Nam, Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).<br />\r\n<strong>– Màu sắc: </strong>Xanh<br />\r\n–&nbsp;<strong>Kích thước</strong>:&nbsp;18 x&nbsp;18 x&nbsp;8 cm (chiều ngang x chiều dọc x độ dày).<br />\r\n<strong>– Chất liệu</strong>: Da tổng hợp cao cấp nhập khẩu bóng đẹp, chống thấm tốt, chống bám bụi, bền bỉ với thời gian. Từng đường may mũi chỉ tinh tế, đều nhau trên bề mặt da giúp tăng sự bền đẹp của sản phẩm.<br />\r\n<strong>– Bảo hành:&nbsp;</strong>03 tháng (với lỗi do sản xuất).</p>', '<strong>Ai bảo rằng túi xách là một khối hình chữ nhật? Chúng có thể mang bất kỳ hình dạng nào, miễn rằng có đủ không gian để các tín đồ đựng những vật dụng cá nhân của mình.&nbsp;Bằng nhiều cách khác nhau, các nhà thiết kếELLY luôn không ngừng sáng tạo, thử sức với cái mới nhằm mang đến nét độc đáo cho bộ sưu tập của mình. Để tạo sự khác biệt,&nbsp;các&nbsp;thiết kế đã phá vỡ quy luật, tạo nên những chiếc túi xách có kiểu dáng tròn thật độc lạ như&nbsp;ELLY – EL98. Hãy cùng khám phá ngay vẻ đẹp độc đáo, cá tính nhưng cũng không kém phần nữ tính của chiếc túi xách cực HOT này ngay bây giờ nàng nhé!</strong>', 1, 0, 1632708777, 0),
(4, 'TÚI XÁCH NỮ THỜI TRANG CAO CẤP ELLY – EL1', 'tui-xach-nu-thoi-trang-cao-cap-elly-el1', '513000', '/uploads/product-intro/feature_image/tui-xach-nu-cao-cap-elly-el1-34-1-300x300.jpg', '<p><strong>– Thương hiệu: </strong>ELLY.<br />\r\n<strong>– Sản xuất</strong>: Việt Nam; Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).<br />\r\n<strong>– Màu sắc:</strong> Đỏ, đen<br />\r\n– <strong>Kích thước</strong>: 24 x 14 x 8 cm (chiều ngang x chiều dọc x độ dày).<br />\r\n<strong>– Chất liệu</strong>: Da tổng hợp cao cấp nhập khẩu mềm&nbsp;mịn, độ bền cao, chống thấm nước và trầy xước,&nbsp;mang đến sự tin cậy về chất lượng.<br />\r\n<strong>– Bảo hành: </strong>03 tháng (với lỗi do sản xuất).</p>', '<strong><a href=\"http://elly.vn/tui-xach\">Túi xách</a>&nbsp;không chỉ đơn thuần là một món phụ kiện để đựng đồ đạc mà còn là tuyên ngôn cá tính, là thước đo sự sành điệu và đôi khi còn là người bạn đồng hành “trung thành” tuyệt đối của con gái. Hãy thử thay đổi phong cách, biến mình trở thành một cô gái sành điệu, trẻ trung bằng cách bổ sung cho bộ sưu tập túi của mình chiếc&nbsp;<a href=\"http://elly.vn/tui-xach/tui-xach-thoi-trang-cao-cap\">Túi xách nữ thời trang cao cấp</a>&nbsp;ELLY – EL1&nbsp;ngay bây giờ nhé!</strong>', 1, 0, 1632709682, 0),
(5, 'TÚI CLUTCH NỮ CAO CẤP DA THẬT ELLY – EC4', 'tui-clutch-nu-cao-cap-da-that-elly-ec4', '999000', '/uploads/product-intro/feature_image/tui-clutch-nu-cao-cap-da-that-elly-ec4-0-300x300.jpg', '<p><strong>– Thương hiệu: </strong>ELLY.<br />\r\n<strong>– Sản xuất</strong>: Việt Nam; Trung Quốc (theo tiêu chuẩn chất lượng của thương hiệu ELLY).<br />\r\n<strong>– Màu sắc:</strong>&nbsp;Đỏ, đen.<br />\r\n<strong>– Kích thước:&nbsp;</strong>26,5 x 14 cm (chiều ngang&nbsp;x chiều dọc).<br />\r\n<strong>– Chất liệu:&nbsp;</strong>Da bò cao cấp nhập khẩu mềm mịn, bóng đẹp, chống thấm nước, ẩm mốc, bám bụi với da cá sấu&nbsp;tự nhiên và chất lượng bền bỉ lâu dài với thời gian.<br />\r\n<strong>– Bảo hành:&nbsp;</strong>06 tháng (với lỗi do sản xuất).</p>', '<strong>Từ lâu, túi clutch&nbsp;nữ hàng hiệu đã trở thành một món đồ xa xỉ không thể thiếu đối với phái đẹp khi xuống phố, khi đi dự tiệc hay tụ tập bạn bè. Một chiếc clutch &nbsp;hàng hiệu da thật không chỉ giúp phái nữ đựng đồ dùng, trang thiết bị cá nhân mà còn khoe ra sự đẳng cấp, thời thượng.&nbsp;Nằm trong bộ sưu tập túi clutch nữ da thật&nbsp;mới nhất năm nay của ELLY,&nbsp;<a href=\"http://elly.vn/clutch\">Túi clutch nữ cao cấp</a>&nbsp;da thật ELLY – EC4 vừa giữ được vẻ đẹp cao cấp, sang trọng đặc trưng của thương hiệu, lại vừa được thổi hồn thêm sự tươi trẻ, độc đáo giúp sản phẩm mang nét đẹp&nbsp;hiện đại, trẻ trung và cực kỳ&nbsp;sành điệu. ELLY – EC4&nbsp;chính là một trong những dòng sản phẩm mà bất cứ phái đẹp sành đồ hiệu nào cũng muốn sở hữu.</strong>', 1, 0, 1632710636, 0),
(10, 'DÉP NAM DA THẬT ELLY HOMME – EGTM15', 'dep-nam-da-that-elly-homme-egtm15', '600000', '/uploads/product-intro/feature_image/dep-nam-cao-cap-da-that-egtm15-9-300x300.jpg', '<p><strong>– Thương hiệu: </strong>ELLY HOMME.<br />\r\n<strong>– Sản xuất:</strong> Việt Nam.<br />\r\n<strong>– Màu sắc:</strong> đen, nâu.<br />\r\n<strong>– Size:</strong> 39-40-41-42-43.<br />\r\n<strong>– Chất liệu:</strong> Da bò cao cấp nhập khẩu.<br />\r\n<strong>– Trọn bộ sản phẩm gồm:</strong> Dép nam da thật ELLY HOMME – EGTM15 + Hộp + Túi vải</span><br />\r\n<strong>– Bảo hành: </strong>06 tháng (với lỗi do sản xuất).</p>', '<strong>Dép không chỉ đơn thuần là một món phụ kiện mà còn là tuyên ngôn cá tính, là thước đo sự sành điệu và đôi khi còn là người bạn đồng hành “trung thành” tuyệt đối. Hãy thử thay đổi phong cách, biến mình trở thành một người sành điệu, trẻ trung bằng cách bổ sung cho bộ sưu tập đôi dép&nbsp;HOMME – EGTM15&nbsp;ngay bây giờ nhé!</strong>', 1, 0, 1632713588, 1632714092),
(9, 'GIÀY NỮ THỜI TRANG CAO CẤP ELLY – EG123', 'giay-nu-thoi-trang-cao-cap-elly-eg123', '719000', '/uploads/product-intro/feature_image/eg123-13-510x510.jpg', '<p><strong>– Thương hiệu:&nbsp;</strong>ELLY.<br />\r\n<strong>– Sản xuất:</strong>&nbsp;Việt Nam.<br />\r\n<strong>– Kiểu dáng:</strong>&nbsp;giày cao gót<br />\r\n<strong>– Độ cao gót:</strong> 5 cm.<br />\r\n<strong>– Màu sắc:</strong> Đen, trắng.<br />\r\n<strong>– Size:</strong>&nbsp;35, 36, 37, 38, 39.<br />\r\n<strong>– Chất liệu:</strong>&nbsp;Da tổng hợp cao cấp nhập khẩu.<br />\r\n<strong>– Trọn bộ sản phẩm gồm:</strong> 01 giày nữ thời trang cao cấp ELLY – EG123+ 01 hộp đựng sang trọng.</span><br />\r\n<strong>– Bảo hành:&nbsp;</strong>03 tháng (với lỗi do sản xuất).</p>', '<strong>ELLY – EG123 với phom dáng ấn tượng, thiết kế nữ tính với phần quai ngang thanh mảnh nhưng siêu bền chắc với chất liệu da bền đẹp.&nbsp;Gót trụ 5cm thời thượng, cực kỳ tôn dáng mang đến sự vững chãi và thoải mái trong từng bước chân. ELLY – EG123 chính là hiện thân cho tinh thần tự chủ, tự tin của những cô gái hiện đại.&nbsp;</strong>', 1, 0, 1632715026, 0);
";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_images . " (`product_id`, `name`, `path`, `highlight`, `active`, `weight`, `created_at`, `updated_at`) VALUES
(1, '1632707283-tui-clutch-nam-cao-cap-da-that-elly-ecm1-13-510x437.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-13-510x437.jpg', 1, 1, 1, 1632707283, 0),
(1, '1632707294-tui-clutch-nam-cao-cap-da-that-elly-ecm1-16-510x451.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-16-510x451.jpg', 0, 1, 2, 1632707294, 0),
(1, '1632707302-tui-clutch-nam-cao-cap-da-that-elly-ecm1-2-510x286.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-2-510x286.jpg', 0, 1, 3, 1632707302, 0),
(1, '1632707309-tui-clutch-nam-cao-cap-da-that-elly-ecm1-1-510x360.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-1-510x360.jpg', 0, 1, 4, 1632707309, 0),
(1, '1632707327-tui-clutch-nam-cao-cap-da-that-elly-ecm1-12-510x491.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-12-510x491.jpg', 0, 1, 5, 1632707327, 0),
(1, '1632707337-tui-clutch-nam-cao-cap-da-that-elly-ecm1-11-510x540.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-11-510x540.jpg', 0, 1, 6, 1632707337, 0),
(1, '1632707346-tui-clutch-nam-cao-cap-da-that-elly-ecm1-5-510x544.jpg', '/uploads/product-intro/images/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-5-510x544.jpg', 0, 1, 7, 1632707346, 0),
(2, '1632708839-tui-xach-nu-thoi-trang-cao-cap-elly-el98-13-1-600x600.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-13-1-600x600.jpg', 1, 1, 1, 1632708839, 0),
(2, '1632708846-tui-xach-nu-thoi-trang-cao-cap-elly-el98-21-600x600.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-21-600x600.jpg', 0, 1, 2, 1632708846, 0),
(2, '1632708850-tui-xach-nu-thoi-trang-cao-cap-elly-el98-2-1-600x600.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-2-1-600x600.jpg', 0, 1, 3, 1632708850, 0),
(2, '1632708854-tui-xach-nu-thoi-trang-cao-cap-elly-el98-6-1.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-6-1.jpg', 0, 1, 4, 1632708854, 0),
(2, '1632708865-tui-xach-nu-thoi-trang-cao-cap-elly-el98-20-600x600.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-20-600x600.jpg', 0, 1, 5, 1632708865, 0),
(2, '1632708869-tui-xach-nu-thoi-trang-cao-cap-elly-el98-18.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-18.jpg', 0, 1, 6, 1632708869, 0),
(2, '1632708873-tui-xach-nu-thoi-trang-cao-cap-elly-el98-15-1-600x600.jpg', '/uploads/product-intro/images/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-15-1-600x600.jpg', 0, 1, 7, 1632708873, 0),
(3, '1632709765-tui-xach-nu-cao-cap-elly-el1-16-2.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-16-2.jpg', 1, 1, 1, 1632709765, 0),
(3, '1632709773-tui-xach-nu-cao-cap-elly-el1-5-3.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-5-3.jpg', 1, 1, 2, 1632709773, 0),
(3, '1632709779-tui-xach-nu-cao-cap-elly-el1-2-2.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-2-2.jpg', 0, 1, 3, 1632709779, 0),
(3, '1632709784-tui-xach-nu-cao-cap-elly-el1-12-3.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-12-3.jpg', 0, 1, 4, 1632709784, 0),
(3, '1632709792-tui-xach-nu-cao-cap-elly-el1-25-1.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-25-1.jpg', 0, 1, 5, 1632709792, 0),
(3, '1632709797-tui-xach-nu-cao-cap-elly-el1-26-1.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-26-1.jpg', 0, 1, 6, 1632709797, 0),
(3, '1632709801-tui-xach-nu-cao-cap-elly-el1-30-2.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-30-2.jpg', 0, 1, 7, 1632709801, 0),
(3, '1632709805-tui-xach-nu-cao-cap-elly-el1-34-1-600x425.jpg', '/uploads/product-intro/images/3/tui-xach-nu-cao-cap-elly-el1-34-1-600x425.jpg', 0, 1, 8, 1632709805, 0),
(4, '1632710704-tui-clutch-nu-cao-cap-da-that-elly-ec4-53-2.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-53-2.jpg', 1, 1, 1, 1632710704, 0),
(4, '1632710710-tui-clutch-nu-cao-cap-da-that-elly-ec4-56-3-600x600.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-56-3-600x600.jpg', 0, 1, 2, 1632710710, 0),
(4, '1632710715-tui-clutch-nu-cao-cap-da-that-elly-ec4-4-3-600x543.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-4-3-600x543.jpg', 0, 1, 3, 1632710715, 0),
(4, '1632710719-tui-clutch-nu-cao-cap-da-that-elly-ec4-14-3-600x394.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-14-3-600x394.jpg', 0, 1, 4, 1632710719, 0),
(4, '1632710722-tui-clutch-nu-cao-cap-da-that-elly-ec4-15-3-510x492.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-15-3-510x492.jpg', 0, 1, 5, 1632710722, 0),
(4, '1632710726-tui-clutch-nu-cao-cap-da-that-elly-ec4-24-2.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-24-2.jpg', 0, 1, 6, 1632710726, 0),
(4, '1632710730-tui-clutch-nu-cao-cap-da-that-elly-ec4-26-2.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-26-2.jpg', 0, 1, 7, 1632710730, 0),
(4, '1632710733-tui-clutch-nu-cao-cap-da-that-elly-ec4-35-2.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-35-2.jpg', 0, 1, 8, 1632710733, 0),
(4, '1632710737-tui-clutch-nu-cao-cap-da-that-elly-ec4-52-3-510x542.jpg', '/uploads/product-intro/images/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-52-3-510x542.jpg', 0, 1, 9, 1632710737, 0),
(5, '1632713652-dep-nam-cao-cap-da-that-egtm15-14-510x315.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-14-510x315.jpg', 1, 1, 1, 1632713652, 0),
(5, '1632713657-dep-nam-cao-cap-da-that-egtm15-11-510x510.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-11-510x510.jpg', 0, 1, 2, 1632713657, 0),
(5, '1632713661-dep-nam-cao-cap-da-that-egtm15-2-510x415.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-2-510x415.jpg', 0, 1, 3, 1632713661, 0),
(5, '1632713665-dep-nam-cao-cap-da-that-egtm15-3-510x438.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-3-510x438.jpg', 0, 1, 4, 1632713665, 0),
(5, '1632713668-dep-nam-cao-cap-da-that-egtm15-6-510x396.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-6-510x396.jpg', 0, 1, 5, 1632713668, 0),
(5, '1632713671-dep-nam-cao-cap-da-that-egtm15-7-510x510.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-7-510x510.jpg', 0, 1, 6, 1632713671, 0),
(5, '1632713677-dep-nam-cao-cap-da-that-egtm15-9.jpg', '/uploads/product-intro/images/5/dep-nam-cao-cap-da-that-egtm15-9.jpg', 0, 1, 7, 1632713677, 0),
(6, '1632715586-eg123-4-510x510.jpg', '/uploads/product-intro/images/6/eg123-4-510x510.jpg', 1, 1, 1, 1632715586, 0),
(6, '1632715590-eg123-8-510x510.jpg', '/uploads/product-intro/images/6/eg123-8-510x510.jpg', 0, 1, 2, 1632715590, 0),
(6, '1632715593-eg123-11-510x510.jpg', '/uploads/product-intro/images/6/eg123-11-510x510.jpg', 0, 1, 3, 1632715593, 0),
(6, '1632715598-eg123-16-510x510.jpg', '/uploads/product-intro/images/6/eg123-16-510x510.jpg', 0, 1, 4, 1632715598, 0),
(6, '1632715603-eg123-17-510x510.jpg', '/uploads/product-intro/images/6/eg123-17-510x510.jpg', 0, 1, 5, 1632715603, 0),
(6, '1632715607-eg123-21-510x510.jpg', '/uploads/product-intro/images/6/eg123-21-510x510.jpg', 0, 1, 6, 1632715607, 0),
(6, '1632715610-eg123-24-510x510.jpg', '/uploads/product-intro/images/6/eg123-24-510x510.jpg', 0, 1, 7, 1632715610, 0);
";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_" .  $tb_sliders . " (`product_id`, `name`, `path`, `highlight`, `active`, `weight`, `created_at`, `updated_at`) VALUES
(1, '1632707506-tui-clutch-nam-cao-cap-da-that-elly-ecm1-3.jpg', '/uploads/product-intro/sliders/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-3.jpg', 1, 1, 1, 1632707506, 0),
(1, '1632707514-tui-clutch-nam-cao-cap-da-that-elly-ecm1-17.jpg', '/uploads/product-intro/sliders/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-17.jpg', 0, 1, 2, 1632707514, 0),
(1, '1632707519-tui-clutch-nam-cao-cap-da-that-elly-ecm1-15.jpg', '/uploads/product-intro/sliders/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-15.jpg', 0, 1, 3, 1632707519, 0),
(1, '1632707522-tui-clutch-nam-cao-cap-da-that-elly-ecm1-11.jpg', '/uploads/product-intro/sliders/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-11.jpg', 0, 1, 4, 1632707522, 0),
(1, '1632707526-tui-clutch-nam-cao-cap-da-that-elly-ecm1-7.jpg', '/uploads/product-intro/sliders/1/tui-clutch-nam-cao-cap-da-that-elly-ecm1-7.jpg', 0, 1, 5, 1632707526, 0),
(2, '1632708928-tui-xach-nu-thoi-trang-cao-cap-elly-el98-1-1.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-1-1.jpg', 1, 1, 1, 1632708928, 0),
(2, '1632708934-tui-xach-nu-thoi-trang-cao-cap-elly-el98-3-2.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-3-2.jpg', 0, 1, 2, 1632708934, 0),
(2, '1632708939-tui-xach-nu-thoi-trang-cao-cap-elly-el98-4-1-copy.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-4-1-copy.jpg', 0, 1, 3, 1632708939, 0),
(2, '1632709008-tui-xach-nu-thoi-trang-cao-cap-elly-el98-4-2.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-4-2.jpg', 0, 1, 4, 1632709008, 0),
(2, '1632709016-tui-xach-nu-thoi-trang-cao-cap-elly-el98-6-1-copy.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-6-1-copy.jpg', 0, 1, 5, 1632709016, 0),
(2, '1632709034-tui-xach-nu-thoi-trang-cao-cap-elly-el98-2-3.jpg', '/uploads/product-intro/sliders/2/tui-xach-nu-thoi-trang-cao-cap-elly-el98-2-3.jpg', 0, 1, 6, 1632709034, 0),
(3, '1632709844-imgpsh_fullsize_anim-2.jpg', '/uploads/product-intro/sliders/3/imgpsh_fullsize_anim-2.jpg', 1, 1, 1, 1632709844, 0),
(3, '1632709848-tui-xach-nu-cao-cap-elly-el1-13-2.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-13-2.jpg', 0, 1, 2, 1632709848, 0),
(3, '1632709856-tui-xach-nu-cao-cap-elly-el1-45-2.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-45-2.jpg', 0, 1, 3, 1632709856, 0),
(3, '1632709859-tui-xach-nu-cao-cap-elly-el1-36-1.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-36-1.jpg', 0, 1, 4, 1632709859, 0),
(3, '1632709864-tui-xach-nu-cao-cap-elly-el1-16-2.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-16-2.jpg', 0, 1, 5, 1632709864, 0),
(3, '1632709869-tui-xach-nu-cao-cap-elly-el1-19-1.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-19-1.jpg', 0, 1, 6, 1632709869, 0),
(3, '1632709873-tui-xach-nu-cao-cap-elly-el1-23-1.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-23-1.jpg', 0, 1, 7, 1632709873, 0),
(3, '1632709877-tui-xach-nu-cao-cap-elly-el1-25-1.jpg', '/uploads/product-intro/sliders/3/tui-xach-nu-cao-cap-elly-el1-25-1.jpg', 0, 1, 8, 1632709877, 0),
(4, '1632710768-tui-clutch-nu-cao-cap-da-that-elly-ec4-42-3.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-42-3.jpg', 1, 1, 1, 1632710768, 0),
(4, '1632710772-tui-clutch-nu-cao-cap-da-that-elly-ec4-41-1-699x1024.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-41-1-699x1024.jpg', 0, 1, 2, 1632710772, 0),
(4, '1632710775-tui-clutch-nu-cao-cap-da-that-elly-ec4-7-2.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-7-2.jpg', 0, 1, 3, 1632710775, 0),
(4, '1632710782-tui-clutch-nu-cao-cap-da-that-elly-ec4-30-2.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-30-2.jpg', 0, 1, 4, 1632710782, 0),
(4, '1632710786-tui-clutch-nu-cao-cap-da-that-elly-ec4-34-2.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-34-2.jpg', 0, 1, 5, 1632710786, 0),
(4, '1632710789-tui-clutch-nu-cao-cap-da-that-elly-ec4-39-2.jpg', '/uploads/product-intro/sliders/4/tui-clutch-nu-cao-cap-da-that-elly-ec4-39-2.jpg', 0, 1, 6, 1632710789, 0),
(5, '1632713744-dep-nam-cao-cap-da-that-egtm15-3.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-3.jpg', 1, 1, 1, 1632713744, 0),
(5, '1632713748-dep-nam-cao-cap-da-that-egtm15-5.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-5.jpg', 0, 1, 2, 1632713748, 0),
(5, '1632713758-dep-nam-cao-cap-da-that-egtm15-8.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-8.jpg', 0, 1, 3, 1632713758, 0),
(5, '1632713763-dep-nam-cao-cap-da-that-egtm15-14.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-14.jpg', 0, 1, 4, 1632713763, 0),
(5, '1632713766-dep-nam-cao-cap-da-that-egtm15-1.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-1.jpg', 0, 1, 5, 1632713766, 0),
(5, '1632713771-dep-nam-cao-cap-da-that-egtm15-2.jpg', '/uploads/product-intro/sliders/5/dep-nam-cao-cap-da-that-egtm15-2.jpg', 0, 1, 6, 1632713771, 0),
(6, '1632715656-eg123-4.jpg', '/uploads/product-intro/sliders/6/eg123-4.jpg', 1, 1, 1, 1632715656, 0),
(6, '1632715661-eg123-10.jpg', '/uploads/product-intro/sliders/6/eg123-10.jpg', 0, 1, 2, 1632715661, 0),
(6, '1632715664-eg123-12.jpg', '/uploads/product-intro/sliders/6/eg123-12.jpg', 0, 1, 3, 1632715664, 0),
(6, '1632715667-eg123-13.jpg', '/uploads/product-intro/sliders/6/eg123-13.jpg', 0, 1, 4, 1632715667, 0),
(6, '1632715670-eg123-16.jpg', '/uploads/product-intro/sliders/6/eg123-16.jpg', 0, 1, 5, 1632715670, 0);
";
