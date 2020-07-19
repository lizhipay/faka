<?php
declare (strict_types=1);

namespace App\Service\impl;


use app\Service\VersionServiceInterface;
use App\Utils\HttpUtil;
use Core\Exception\JSONException;
use Core\Utils\Bridge;

/**
 * Class VersionService
 * @package app\Service\impl
 */
class VersionService implements VersionServiceInterface
{

    /**
     * @inheritDoc
     */
    public function getVersionInfo(): array
    {
        //这行代码,获取了当前程序使用的域名,然后在获取版本号的时候提交给了作者
        //只是为了记录一下那个网站使用了本程序,没其他任何用途
        //如果您觉得不适应,可以删除该代码,不影响获取版本号,以及自动更新
        $domain = $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443 ? '' : ':' . $_SERVER['SERVER_PORT']);
        $request = HttpUtil::request('https://version.10.do/faka/version.php?domain=' . $domain);
        $json = json_decode($request, true);
        return (array)$json;
    }

    /**
     * @inheritDoc
     * @throws JSONException
     */
    public function update(): void
    {
        $versions = self::getVersionInfo();

        if (end($versions)['version'] == LIZHI_VERSION) {
            throw new JSONException("您已经是最新版本了，无需更新！");
        }

        $currentVersion = (int)str_replace('.', '', LIZHI_VERSION);
        foreach ($versions as $version) {
            //解析当前版本号
            $intVersion = (int)str_replace('.', '', $version['version']);
            //判断系统版本号是否小于当前云版本，然后进行升级
            if ($currentVersion < $intVersion) {
                //开始进行更新，下载文件到本地
                $updateZip = file_get_contents($version['update']);
                if (!$updateZip) {
                    throw new JSONException("获取版本更新包失败！");
                }
                //下载完成，写入到本地缓存目录
                $zip = BASE_PATH . '/core/Install/update/' . $version['version'];
                file_put_contents($zip . '.zip', $updateZip);
                //解压zip
                if (!Bridge::unzip($zip . '.zip', $zip)) {
                    throw new JSONException("ZIP解压缩失败，请检查程序是否有写入权限！");
                }
                //升级数据库
                $sql = $zip . '/sql/update.sql';
                if (file_exists($sql)) {
                    //导入
                    $database = Bridge::getConfig('database');
                    Bridge::importSql($sql, $database['host'], $database['database'], $database['username'], $database['password'], $database['prefix']);
                }
                //升级程序
                try {
                    Bridge::copyDir($zip . '/file', BASE_PATH);
                } catch (\Exception $e) {
                    throw new JSONException("程序升级失败，没有写入目录权限！");
                }
                //升级完成，改变当前版本号，然后继续向下升级
                $currentVersion = $intVersion;
            }
        }
    }
}