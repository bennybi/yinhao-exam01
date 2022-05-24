<?php

namespace console\models\commands\sys;

use Yii;
use console\models\commands\BaseCommander;
use yii\base\Exception;
use common\interfaces\Command;
use common\models\User;

class InitCommander extends BaseCommander implements Command {

    public function init() {
        parent::init();
    }

    /**
     * 
     * @param type $args
     */
    public function beUsers($args = []) {
        $tables = [
            '{{%user}}',
        ];
        foreach ($tables as $table) {
            Yii::$app->db->createCommand()->truncateTable($table)->execute();
        }

        $model = new User();
        $model->loadDefaultValues();
        $model->setAttributes([
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $model->setPassword('adminadmin');
        $model->generateAuthKey();
        $model->generatePasswordResetToken();
        $model->generateEmailVerificationToken();

        if (!$model->save()) {
            throw new Exception(implode(',', $model->firstErrors));
        }
    }

    /**
     * 
     * @param type $args
     */
    public function suppliers($args = []) {
        $queues = IotQueueList::getData();
        foreach ($queues as $queue) {
            Yii::$app->rabbitmq->declareQueue($queue['code']);
        }
    }

}
