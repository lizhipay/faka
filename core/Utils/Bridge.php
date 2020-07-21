<?php
declare (strict_types=1);

namespace Core\Utils;

use Core\Exception\JSONException;
use Rah\Danpu\Dump;
use Rah\Danpu\Exception;
use Rah\Danpu\Import;

/**
 * 小帮手
 * Class Bridge
 * @package Core\Utils
 */
class Bridge
{
    /**
     * 获取PHP源代码
     * @param \ReflectionClass $ref
     * @return false|string
     */
    public static function getSource(\ReflectionClass $ref)
    {
        $path = $ref->getFileName();    #获取脚本文件文件名
        return file_get_contents($path);
    }

    /**
     * 获取配置信息
     * @param string $name
     * @return mixed
     */
    public static function getConfig(string $name)
    {
        return require(BASE_PATH . '/config/' . $name . '.php');
    }

    /**
     * 设置配置中的键值对
     * @param string $name
     * @param array $data
     * @throws JSONException
     */
    public static function setConfig(string $name, array $data): void
    {
        $config = self::getConfig($name);
        foreach ($data as $x => $b) {
            $config[$x] = $b;
        }
        //写入到文件
        $ret = "<?php
declare (strict_types=1);\n\nreturn [\n";
        foreach ($config as $k => $v) {
            $ret .= "    '{$k}' => '{$v}',\n";
        }
        $ret .= '];';
        if (file_put_contents(BASE_PATH . '/config/' . $name . '.php', $ret) === false) {
            throw new JSONException("没有文件写入权限！");
        }
    }

    /**
     * 获取支付配置信息
     * @param string $name
     * @return mixed
     */
    public static function getPayConfig(string $name)
    {
        return require(BASE_PATH . '/app/Pay/' . $name . '/Config/Config.php');
    }

    /**
     * 获取支付信息
     * @param string $name
     * @return mixed
     */
    public static function getPayInfo(string $name)
    {
        return require(BASE_PATH . '/app/Pay/' . $name . '/Config/Info.php');
    }

    /**
     * 设置支付配置中的键值对
     * @param string $name
     * @param array $data
     * @throws JSONException
     */
    public static function setPayConfig(string $name, array $data): void
    {
        $config = self::getPayConfig($name);
        foreach ($data as $x => $b) {
            $config[$x] = $b;
        }
        //写入到文件
        $ret = "<?php
declare (strict_types=1);\n\nreturn [\n";
        foreach ($config as $k => $v) {
            $ret .= "    '{$k}' => '{$v}',\n";
        }
        $ret .= '];';
        if (file_put_contents(BASE_PATH . '/app/Pay/' . $name . '/Config/Config.php', $ret) === false) {
            throw new JSONException("没有文件写入权限！");
        }
    }

    /**
     * 导入SQL文件
     * @param string $sql
     * @param string $host
     * @param string $db
     * @param string $username
     * @param string $password
     * @param string $prefix
     * @throws JSONException
     */
    public static function importSql(string $sql, string $host, string $db, string $username, string $password, string $prefix)
    {

        //处理前缀
        $sqlSrc = str_replace('__PREFIX__', $prefix, (string)file_get_contents($sql));
        if (file_put_contents($sql . '.sql', $sqlSrc) === false) {
            throw new JSONException("没有写入权限，请检查权限是否足够");
        }
        $dump = new Dump();
        $dump
            ->file($sql . '.sql')
            ->dsn('mysql:dbname=' . $db . ';host=' . $host)
            ->user($username)
            ->pass($password)
            ->tmp(BASE_PATH . '/runtime/tmp');
        try {
            new Import($dump);
            unlink($sql . '.sql');
        } catch (\Exception $e) {
            throw new JSONException("数据库导入失败，请检查填写的数据库信息是否正确");
        }
    }

    /**
     * 压缩文件
     * @param array $files 待压缩文件 array('d:/test/1.txt'，'d:/test/2.jpg');【文件地址为绝对路径】
     * @param string $filePath 输出文件路径 【绝对文件地址】 如 d:/test/new.zip
     * @return string|bool
     * @throws JSONException
     */
    public static function zip($files, $filePath): bool
    {
        try {
            //检查参数
            if (empty($files) || empty($filePath)) {
                return false;
            }
            //压缩文件
            $zip = new \ZipArchive();
            $zip->open($filePath, \ZipArchive::CREATE);
            foreach ($files as $key => $file) {
                //检查文件是否存在
                if (!file_exists($file)) {
                    return false;
                }
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            return true;
        } catch (Exception $e) {
            throw new JSONException("压缩失败，请安装php-zip扩展！");
        }
    }

    /**
     * zip解压方法
     * @param string $filePath 压缩包所在地址 【绝对文件地址】d:/test/123.zip
     * @param string $path 解压路径 【绝对文件目录路径】d:/test
     * @return bool
     * @throws JSONException
     */
    public static function unzip($filePath, $path): bool
    {
        try {
            if (empty($path) || empty($filePath)) {
                return false;
            }
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $zip->extractTo($path);
                $zip->close();
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new JSONException("解压缩失败，请安装php-zip扩展！");
        }
    }

    /**
     * 拷贝目录
     * @param string $src 源目录
     * @param string $dst 目标目录
     */
    public static function copyDir(string $src, string $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0777, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::copyDir($src . '/' . $file, $dst . '/' . $file);
                    continue;
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}