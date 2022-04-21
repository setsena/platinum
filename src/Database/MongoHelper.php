<?php
namespace Platinum\Database;

class MongoHelper
{
    //release 
    static function isMongoId($str)
    {
        if (preg_match('/^[a-z0-9]{24}$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
}