<?php
namespace Platinum\System;

class Files
{


    /**
     * 创建文件夹
     * @param string $path
     * @param bool $p
     * @param int $mod
     * @return bool
     */
    static function mkdir(string $path, bool $p = false, int $mod = 0777)
    {
        if (!file_exists($path))
            return mkdir($path, $mod, $p);
        else
            return true;
    }

    /**
     * 查看目录内容
     * @param $path
     * @return array
     */
    static function ll($path)
    {
        if (is_dir($path)) {
            $handle = opendir($path);
            $files = [];
            while (($file = readdir($handle)) !== false) {

                if ($file == '.' || $file == '..') {

                    continue;

                } else {
                    $files[] = $file;
                }
            }

            closedir($path);

            return $files;

        } else {
            return [];
        }
    }

    /**
     * @param $old_path
     * @param $new_path
     * @return bool
     * @throws Exception
     */
    static function mv($old_path, $new_path)
    {
        if (file_exists($new_path)) {
            throw new \Exception('new path exists');
        }
        if (!is_readable($old_path)) {
            throw new \Exception('old path unreadable');
        }

        return rename($old_path, $new_path);

    }

    /**
     * 判断文件夹或文件是否为空
     * @param $path
     * @return bool
     */
    static function is_empty($path)
    {
        if (!file_exists($path)) {
            //return ;
            return true;
        }
        //is dir
        if (is_dir($path)) {
            $handle = opendir($path);

            while (($file = readdir($handle)) !== false) {

                if ($file == '.' || $file == '..') {

                    continue;
                }

                return false;
            }
            return true;
        } else {
            return filesize($path) <= 0;
        }
        //is file
    }


    /**
     * 删除文件或目录
     * @param $path
     * @param bool $r 是否遍历删除
     * @return bool
     */
    static public function rm($path, $r = false)
    {
        if (is_dir($path)) {

            if (self::is_empty($path)) {
                return rmdir($path);

            } else if ($r) {
                $handle = opendir($path);

                while (($file = readdir($handle)) !== false) {

                    if ($file == '.' || $file == '..') {

                        continue;

                    }

                    if (is_dir($path . '/' . $file)) {

                        self::rm($path . '/' . $file, $r);

                    } else {

                        if (unlink($path . '/' . $file)) {

                            //echo '删除文件' . $file . '成功';

                        }

                    }

                }

                closedir($handle);

                return rmdir($path);
            } else {
                return false;
            }

        } else if (file_exists($path)) {
            unlink($path);
        } else {
            return false;
        }

        return true;
    }

    static function cp()
    {
        //TODO
    }
}
