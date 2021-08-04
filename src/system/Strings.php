<?php
namespace Platinum\System;

class Strings
{
    /**
     * 随机生成emoji字符
     * @param int $length 生成字符串长度
     * @return string
     */
    static function randEmoji(int $length=1)
    {
        $emo = ['👀','👂','👅','👄','💋','👓','👔','👕','👖','👗','👘','👙','👚','👛','👜','👝','🎒','💼','👞','👟','👠','👡','👢','👑','👒','🎩','🎓','💄','💅','💍','🌂','💐','🌸','💮','🌹','🌺','🌻','🌼','🌷','🌱','🌲','🌳','🌾','🌿','🍁','🍂','🍃','🍇','🍈','🍉','🍊','🍋','🍌','🍍','🍎','🍏','🍐','🍑','🍒','🍓','🍅','🍆','🌽','🍄','🌰','🍞','🍖','🍗','🍔','🍟','🍕','🍳','🍲','🍱','🍘','🍙','🍚','🍛','🍜','🍝','🍠','🍢','🍣','🍤','🍥','🍡','🍦','🍧','🍨','🍩','🍪','🎂','🍰','🍫','🍬','🍭','🍮','🍯','🍼','☕','🍵','🍶','🍷','🍸','🍹','🍺','🍻','🍴','🎪','🎭','🎨','🎰','🚣','🛀','🎫','🏆','⚽','⚾','🏀','🏈','🏉','🎾','🎱','🎳','⛳','🎣','🎽','🎿','🏂','🏄','🏇','🏊','🚴','🚵','🎯','🎲','🎷','🎸','🎺','🎻'];
        $s = '';
        $c = count($emo);
        for($i=0;$i<$length;$i++){
            $s .= $emo[mt_rand(0,$c-1)];
        }
        return $s;
    }

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


    //字符串转Unicode编码
    static function unicode_encode($strLong)
    {
        $strArr = preg_split('/(?<!^)(?!$)/u', $strLong);//拆分字符串为数组(含中文字符)
        $resUnicode = '';
        foreach ($strArr as $str) {
            $bin_str = '';
            $arr = is_array($str) ? $str : str_split($str);//获取字符内部数组表示,此时$arr应类似array(228, 189, 160)
            foreach ($arr as $value) {
                $bin_str .= decbin(ord($value));//转成数字再转成二进制字符串,$bin_str应类似111001001011110110100000,如果是汉字"你"
            }
            $bin_str = preg_replace('/^.{4}(.{4}).{2}(.{6}).{2}(.{6})$/', '$1$2$3', $bin_str);//正则截取, $bin_str应类似0100111101100000,如果是汉字"你"
            $unicode = dechex(bindec($bin_str));//返回unicode十六进制
            $_sup = '';
            for ($i = 0; $i < 4 - strlen($unicode); $i++) {
                $_sup .= '0';//补位高字节 0
            }
            $str = '\\u' . $_sup . $unicode; //加上 \u 返回
            $resUnicode .= $str;
        }
        return $resUnicode;
    }

    //Unicode编码转字符串方法1
    static function unicode_decode($name)
    {
        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches)) {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++) {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0) {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code) . chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $name .= $c;
                } else {
                    $name .= $str;
                }
            }
        }
        return $name;
    }


}