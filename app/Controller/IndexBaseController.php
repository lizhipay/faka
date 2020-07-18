<?php
declare (strict_types=1);

namespace App\Controller;

use Core\Exception\RuntimeException;
use Core\Utils\Bridge;
use Core\Utils\View;

/**
 * Class AdminApiBaseController
 * @package app\Controller
 */
abstract class IndexBaseController
{
    /**
     * 生成JSON格式
     * @param int $code
     * @param string|null $message
     * @param array|null $data
     * @return array
     */
    public function json(int $code, ?string $message = null, ?array $data = []): array
    {
        $json['code'] = $code;
        $message ? $json['msg'] = $message : null;
        $json['data'] = $data;
        return $json;
    }

    /**
     * @param string $title
     * @param string $template
     * @param array $data
     * @return string
     * @throws RuntimeException
     */
    public function render(string $title, string $template, array $data = []): string
    {
        try {
            $data['title'] = $title;
            $data['user'] = Bridge::getConfig('user');
            return View::render('index/' . $template, $data);
        } catch (\SmartyException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}