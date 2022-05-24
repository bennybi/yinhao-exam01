<?php

namespace console\models\commands;

use Yii;
use yii\base\Component;
use yii\base\Exception;

class BaseCommander extends Component {

    public $log;
    public $time_start;
    public $time_end;
    public $cmds = [];

    public function execute() {
        foreach ($this->cmds as $cmd) {
            $method = $cmd['name'];
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], ['args' => $cmd['args']]);
            } else {
                throw new Exception(sprintf('The required method "%s" does not exist for %s', $method, get_class($this)));
            }
        }
    }

    public function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

}
