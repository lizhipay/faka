<?php
declare (strict_types=1);

namespace app\Controller\Index\Api;


use App\Controller\IndexBaseController;
use App\Utils\StringUtil;
use Core\Exception\JSONException;
use Core\Utils\Bridge;

/**
 * Class InstallController
 * @package app\Controller\Index\Api
 */
class InstallController extends IndexBaseController
{
    /**
     * @param $host
     * @param $database
     * @param $username
     * @param $password
     * @param $prefix
     * @param $user
     * @param $pass
     * @return array
     * @throws JSONException
     */
    public function install($host, $database, $username, $password, $prefix, $user, $pass): array
    {
        if (file_exists(BASE_PATH . '/core/Install/lock')) {
            throw new JSONException("您已经安装过了，如果想重新安装，请删除" . BASE_PATH . '/app/lock' . '文件，即可重新安装!');
        }
        $host = $host == '' ? 'localhost' : $host;
        //导入数据库
        Bridge::importSql(BASE_PATH . '/core/Install/install.sql', $host, $database, $username, $password, $prefix);
        //设置数据库账号密码
        Bridge::setConfig('database', [
            'host' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'prefix' => $prefix
        ]);
        $salt = md5(StringUtil::generateRandStr(32));
        //设置账号密码
        Bridge::setConfig('user', [
            'user' => $user,
            'pass' => StringUtil::generatePassword($pass, $salt),
            'salt' => $salt
        ]);
        //安装完成，写入安装lock文件
        file_put_contents(BASE_PATH . '/core/Install/lock', '');
        return $this->json(200, '安装完成');
    }
}