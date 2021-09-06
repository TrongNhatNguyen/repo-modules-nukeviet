<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hugonhatnguyen <nguyentrongnhat230600@gmail.com>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 30/08/2021 09:50
 */

class Helper
{
    // convert tên file:
    public static function convertNameFile($text, string $divider = '-')
    {
        // chuyển ngữ
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // trim
        $text = trim($text, $divider);

        // loại bỏ dải phân cách trùng lặp
        $text = preg_replace('~-+~', $divider, $text);

        // chữ thường
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    // convert URL:
    public static function convertToSlug($text, string $divider = '-')
    {
        // thay thế không phải chữ cái hoặc chữ số bằng dấu phân cách
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // chuyển ngữ
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // loại bỏ các ký tự không mong muốn
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // loại bỏ dải phân cách trùng lặp
        $text = preg_replace('~-+~', $divider, $text);

        // chữ thường
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    // chuyển đổi ngày giờ có thứ:
    public static function getWeekdayVi(int $time) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = getdate($time);
        $weekday = strtolower($date['weekday']);
        switch($weekday) {
            case 'monday':
                $weekday = 'Thứ hai';
                break;
            case 'tuesday':
                $weekday = 'Thứ ba';
                break;
            case 'wednesday':
                $weekday = 'Thứ tư';
                break;
            case 'thursday':
                $weekday = 'Thứ năm';
                break;
            case 'friday':
                $weekday = 'Thứ sáu';
                break;
            case 'saturday':
                $weekday = 'Thứ bảy';
                break;
            default:
                $weekday = 'Chủ nhật';
                break;
        }
        return $weekday.' - '.date('d/m/Y H:i:s', $time);
    }
}
