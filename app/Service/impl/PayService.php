<?php
declare (strict_types=1);

namespace App\Service\impl;


use app\Service\PayServiceInterface;
use Core\Utils\Bridge;

class PayService implements PayServiceInterface
{

    /**
     * @inheritDoc
     */
    public function getPlatforms(): array
    {
        $path = BASE_PATH . '/app/Pay/';
        $list = scandir($path);
        $dir = [];

        foreach ($list as $item) {
            if ($item != '.' && $item != '..' && is_dir($path . $item)) {
                $dir[] = $item;
            }
        }

        //插件列表
        $plug = [];

        foreach ($dir as $value) {
            $platformInfo = $this->getPlatformInfo($value);
            if (!empty($platformInfo)) {
                $plug[] = $platformInfo;
            }
        }
        return $plug;
    }


    /**
     * @inheritDoc
     */
    public function getPlatformInfo(string $handle): array
    {
        $plugPath = BASE_PATH . '/app/Pay/' . $handle;
        //判断插件信息是否存在
        if (file_exists($plugPath . '/Config/Info.php') && file_exists($plugPath . '/Config/Submit.php')) {
            //解析信息
            $info = require($plugPath . '/Config/Info.php');
            $submit = require($plugPath . '/Config/Submit.php');
            //获取配置设置submit的默认值
            $payConfig = Bridge::getPayConfig($handle);

            foreach ($submit as $index => $item) {
                if (isset($payConfig[$item['name']])) {
                    $submit[$index]['default'] = $payConfig[$item['name']];
                }
            }
            return [
                'id' => $handle,
                'handle' => $handle,
                'info' => $info,
                'submit' => $submit
            ];
        }
        return [];
    }
}