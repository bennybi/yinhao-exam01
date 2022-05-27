<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ExportForm is the model behind the contact form.
 */
class ExportForm extends Model {

    public $ids;
    public $columns = ['id'];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['ids', 'columns',], 'required'],
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
