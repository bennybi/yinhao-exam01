<?php

namespace common\models\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * AbstractStaticClass
 *
 * @author ben
 */
abstract class AbstractStaticClass {

    protected static $_data;

    /**
     * for override
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '') {
        if (is_null(static::$_data)) {
            static::$_data = [
            ];
        }
        if ($id !== '' && !empty($attr)) {
            return static::$_data[$id][$attr];
        }
        if ($id !== '' && empty($attr)) {
            return static::$_data[$id];
        }
        return static::$_data;
    }

    public static function getLabel($id) {
        $result = static::getData($id, 'label');
        return is_array($result) ? "" : $result;
    }

    public static function getHashMap($keyField, $valField) {
        $key = static::class . Yii::$app->language . $keyField . $valField;
        $data = Yii::$app->cache->get($key);

        if ($data === false) {
            $data = ArrayHelper::map(static::getData(), $keyField, $valField);
            Yii::$app->cache->set($key, $data);
        }

        return $data;
    }

}
