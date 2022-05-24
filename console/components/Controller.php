<?php

namespace console\components;

use Yii;
use yii\console\Controller as BaseController;
use yii\helpers\Console;
use yii\base\Exception;

/**
 * abstract controller for console
 */
abstract class Controller extends BaseController {

    protected $_commands = [];

    public function runSingle($cmd) {
        try {
            if (isset($this->_commands[$cmd])) {
                Yii::trace("Start to run: {$cmd}");
                $singleCommand = Yii::createObject($this->_commands[$cmd]);
                $singleCommand->execute();

                $this->stdout("\nExecuted successfully!\r\n", Console::BG_GREEN, Console::BOLD);
                Yii::trace("Executed command: {$cmd}");
            } else {
                throw new Exception("Command {$cmd} doesn't exist!");
            }
        } catch (Exception $e) {
            Yii::info($e->getMessage());
            echo $e->getMessage();
            $this->stdout("\nExecuted failed!\r\n", Console::BG_RED, Console::BOLD);
        }
    }

    public function actionAll() {
        try {
            foreach ($this->_commands as $_command) {
                Yii::trace("Start to run {$_command['cmd']}");
                $singleCommand = Yii::createObject($_command['cmd']);
                $singleCommand->execute();
                Yii::trace("Command {$_command['cmd']} execused.");
            }
        } catch (Exception $e) {
            Yii::info($e->getMessage());
            echo $e->getMessage();
            $this->stdout("\nExecuted failed!\r\n", Console::BG_RED, Console::BOLD);
        }
    }

}
