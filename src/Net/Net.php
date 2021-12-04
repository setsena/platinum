<?php
namespace Platinum\Net;

class Net
{

    public static function speedTest($url){
        $start = microtime(true);
        $s = file_get_contents($url);
        $des = microtime(true)-$start;

        $fsize =  mb_strlen($s,'8bit');//byte

        $bps = $fsize/$des;

        return $bps;


    }
}