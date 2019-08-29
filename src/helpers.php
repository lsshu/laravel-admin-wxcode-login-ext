<?php
/**
 * Created by PhpStorm.
 * User: lsshu
 * Date: 2019/8/28
 * Time: 19:15
 */

if (!function_exists('getRandString')) {
    /**
     * 返回随机字符串
     * @param int $length
     * @return string
     */
    function getRandString($length = 10) {
        $str="QWERTYUPASDFGHJKZXCVBNM23456789qwertyupasdfghjkzxcvbnm";
        str_shuffle($str);
        return substr(str_shuffle($str),0,$length);
    }
}