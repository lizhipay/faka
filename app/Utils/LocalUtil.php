<?php
declare (strict_types=1);

namespace App\Utils;


use Core\Utils\View;

class LocalUtil
{
    /**
     * 渲染错误页面
     * @param string $message
     * @param string $goUrl
     * @return string
     * @throws \SmartyException
     */
    public static function error(string $message, string $goUrl): string
    {
        return View::render('admin/error.html', ['msg' => $message, 'url' => $goUrl]);
    }


    /**
     * 跳转地址
     * @param string $url
     */
    public static function redirect(string $url): void
    {
        header('location:' . $url);
    }
}