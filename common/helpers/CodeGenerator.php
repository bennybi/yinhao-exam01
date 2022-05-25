<?php

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * CodeGenerator
 * 
 * @author Ben Bi <jianbinbi@gmail.com>
 */
class CodeGenerator extends \yii\base\Component {

    public static $format = '%1$s%2$s%3$010d';

    public static function getCodeByDate(\yii\db\ActiveRecord $record = null, $prefix = '', $randomLength = 6) {
        if (!is_null($record)) {
            $maxId = $record->find()->max('id') + 1;
            return sprintf('%1$s%2$s%3$s%4$08d', $prefix, date("Ymd"), preg_replace(['/[\_\-\+]/'], ['8'], strtoupper(Yii::$app->security->generateRandomString($randomLength))), $maxId);
        }
        return sprintf('%1$s%2$s%3$s%4$012d', $prefix, date("Ymd"), preg_replace(['/[\_\-\+]/'], ['8'], strtoupper(Yii::$app->security->generateRandomString($randomLength))), time());
    }

    public static function getCode($prefix = '', $randomLength = 10, $format = '%1$s%2$s%3$s') {
        return sprintf($format, $prefix, date("Ymd"), preg_replace(['/[\_\-\+]/'], ['8'], strtoupper(Yii::$app->security->generateRandomString($randomLength))));
    }

    public static function getCodeById(\yii\db\ActiveRecord $record, $prefix = '') {
        $maxId = $record->find()->max('id') + 1;
        return sprintf('%1$s%2$06d', $prefix, $maxId);
    }

    public static function getRandomCode($length = 4) {

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getRandomNumber($length = 4, $includeZero = true) {

        $characters = $includeZero ? '0123456789' : '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function makeCode($prefix = '', $randomLength = 5, $format = '%1$s%2$s%3$s') {
        return sprintf($format, $prefix, date("YmdHis"), strtoupper(static::getRandomCode($randomLength)));
    }

    public static function encrypt($data, $salt = '') {
        return bin2hex($data);
    }

    public static function decrypt($data, $salt = '') {
        return hex2bin($data);
    }

}
