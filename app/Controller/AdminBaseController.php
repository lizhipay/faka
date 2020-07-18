<?php
declare (strict_types=1);

namespace App\Controller;


use Core\Exception\RuntimeException;
use Core\Utils\Bridge;
use Core\Utils\View;

abstract class AdminBaseController
{
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
            return View::render('admin/' . $template, $data);
        } catch (\SmartyException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}