<?php
namespace Platinum\Spider;

class StringHelper
{

    static function randChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    static function randInt($len)
    {
        if ($len == 0) {
            return 0;
        }

        $min = pow(10, $len - 1);
        $max = pow(10, $len) - 1;
        return mt_rand($min, $max);
    }




    //任意编码字符串转UTF-8
    static function encode_charset($str)
    {
        $encode = mb_detect_encoding($str, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }

    //js对象字符串转json字符串
    static function js_object_2_json($str)
    {
        $str = preg_replace('/([\w]+)\s*:/', '"$1":', $str); // asd:2323,
        $str = preg_replace('/:\s*([a-zA-Z]+)\s*/', ':"$1"', $str); // :true :false :123 :123.12
        $str = preg_replace('/\/\*\.*\*\//s', '', $str);// /*...*/
        $str = preg_replace("/'([^']+)'/", '"$1"', $str); // 'asdf'
        return $str;
    }

    //jsonp字符串转json
    static function jsonp_2_json($str)
    {
        preg_match('/[a-zA-Z0-9]+\((.*)\);?/', $str, $match3);
        return $match3[1];
    }


}