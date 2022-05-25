<?php

namespace console\controllers;

use Yii;
use console\models\commands\sys\InitCommander;
use yii\helpers\Console;
use console\components\Controller as BaseController;

/**
 * App Console Sys functionality
 * 指挥官模式, 下达命令集给指挥官
 */
class SysController extends BaseController {

    protected $_commands = [
        'init-be-users' => ['class' => InitCommander::class, 'cmds' => [
                ['name' => 'beUsers', 'args' => []],
            ]],
        'init-suppliers' => ['class' => InitCommander::class, 'cmds' => [
                ['name' => 'suppliers', 'args' => ['num' => 500]],
            ]],
    ];

    /**
     * 
     * @throws \Throwable
     */
    public function actionInitBeUsers() {
        return $this->runSingle($this->action->id);
    }

    /**
     *
     * @throws \Throwable
     */
    public function actionInitSuppliers() {
        return $this->runSingle($this->action->id);
    }

}
