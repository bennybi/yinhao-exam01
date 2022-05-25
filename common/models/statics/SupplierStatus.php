<?php

namespace common\models\statics;

use Yii;

/**
 * SupplierStatus
 *
 */
class SupplierStatus extends AbstractStaticClass {

    const OK = "ok";
    const HOLD = "hold";

    protected static $_data;

    /**
     * 
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '') {
        if (is_null(static::$_data)) {
            static::$_data = [
                static::OK => ['id' => static::OK, 'label' => Yii::t('app', 'OK')],
                static::HOLD => ['id' => static::HOLD, 'label' => Yii::t('app', 'Hold')],
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

}
