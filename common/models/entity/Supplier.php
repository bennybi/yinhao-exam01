<?php

namespace common\models\entity;

use Yii;
use common\models\statics\SupplierStatus;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $t_status
 */
class Supplier extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['t_status'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
        ];
    }

    public function getStatusLabel() {
        return SupplierStatus::getLabel($this->t_status);
    }

    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
        $this->t_status = SupplierStatus::OK;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            't_status' => Yii::t('app', 'T Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SupplierQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\SupplierQuery(get_called_class());
    }

}
