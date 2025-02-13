<?php

namespace Core\Templates;

use Core\Interfaces\TemplateInterface;
use Smarty\Smarty as SmartyTemplate;

class Smarty implements TemplateInterface
{
    public function render(string $view, array $data = [], string $viewPath = VIEWPATH)
    {
        $smarty = new SmartyTemplate();

        $smarty->setTemplateDir($viewPath . '/smarty');
        $smarty->setConfigDir($viewPath . '/smarty/configs');
        $smarty->setCompileDir($viewPath . '/smarty/compile');
        $smarty->setCacheDir($viewPath . '/smarty/cache');

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $smarty->assign($key, $value);
            }
        }

        $smarty->display($view . '.tpl');
    }
}
