<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ExportForm is the model behind the contact form.
 */
class ExportForm extends Model {

    public $ids = [];
    public $entityModelClass;
    public $columns = [];
    protected $_data = [];

    public function getEntityModel() {
        return new $this->entityModelClass;
    }

    public function loadDefaultColumns($exceptCols = []) {
        if (!isset($this->_data['defaultColumns'])) {
            $cols = array_keys($this->entityModelClass::getTableSchema()->columns);
            if (!empty($exceptCols)) {
                $cols = array_diff($cols, $exceptCols);
            }
            $this->_data['defaultColumns'] = array_combine($cols, $cols);
            $this->columns = $cols;
        }
        return $this->_data['defaultColumns'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['columns',], 'required'],
            [['ids',], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'columns' => Yii::t('app', 'Columns'),
        ];
    }

}
