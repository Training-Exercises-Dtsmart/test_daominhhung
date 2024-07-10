<?php

namespace app\modules;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public function init()
    {
        $this->defaultRoute = "employee";
        parent::init();
    }
}