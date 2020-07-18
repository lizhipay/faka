<?php
declare (strict_types=1);

namespace Core\Utils;


class View
{
    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \SmartyException
     */
    public static function render(string $template, array $data = []): string
    {
        $engine = new \Smarty();
        $engine->setTemplateDir(BASE_PATH . '/app/View');
        $engine->setCacheDir(BASE_PATH . '/runtime/view/cache');
        $engine->setCompileDir(BASE_PATH . '/runtime/view/compile');
        $engine->left_delimiter = '#{';
        $engine->right_delimiter = '}';

        foreach ($data as $key => $item) {
            $engine->assign($key, $item);
        }

        $site = Bridge::getConfig('site');
        $engine->assign('site', $site);
        // $engine->display($template);
        return $engine->fetch($template);
    }
}