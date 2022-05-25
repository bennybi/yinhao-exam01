<?php

namespace console\models\commands\sys;

use Yii;
use console\models\commands\BaseCommander;
use yii\base\Exception;
use common\interfaces\Command;
use common\models\User;
use common\models\entity\Supplier;
use common\helpers\CodeGenerator;

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
    public function suppliers($args = ['num' => 5]) {
        $tables = [
            '{{%supplier}}',
        ];
        foreach ($tables as $table) {
            Yii::$app->db->createCommand()->truncateTable($table)->execute();
        }

        for ($i = 0; $i < $args['num']; $i++) {
            $model = new Supplier();
            $model->loadDefaultValues();

            $code = CodeGenerator::getRandomCode(3);
            while (true) {
                if ($model->find()->where(['code' => $code])->exists()) {
                    $code = CodeGenerator::getRandomCode(3);
                } else {
                    break;
                }
            }

            $model->setAttributes([
                "name" => "Supplier {$i}",
                "code" => $code,
            ]);

            if (!$model->save()) {
                throw new Exception(implode(',', $model->firstErrors));
            }
        }
    }

}
