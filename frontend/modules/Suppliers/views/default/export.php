<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::t('app', '{s0}', ['s0' => Yii::t('app', 'Which column(s) should be included?'),]);
?>

<?php
$form = ActiveForm::begin([
            'action' => ['export',],
            'options' => [
                'id' => 'supplier-export-form',
                'data-pjax' => true,
        ]]);
?>

<div class="panel-body">
    <?php
    echo $form->field($model, 'ids')->hiddenInput()->label(false);
    echo $form->field($model, 'columns')->checkboxList([
        'id' => 'id',
        'code' => 'code',
        'name' => 'name',
        't_status' => 't_status',
            ],
            ['separator' => '<br>'],
    );

    echo Html::beginTag('div', ['class' => 'box-footer clearfix']);
    echo Html::a('<i class="fa fa-close"></i> ' . Yii::t('app', 'Close'), ['index'], ['data-dismiss' => 'modal', 'class' => 'btn btn-default float-right', 'title' => Yii::t('app', 'Cancel'),]);
    echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app', 'Ok'), ['type' => 'button', 'class' => 'btn btn-primary float-right']);
    echo Html::endTag('div');
    ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = "";
$this->registerJs($js);
?>

