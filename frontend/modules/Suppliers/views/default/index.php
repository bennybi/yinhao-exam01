<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\CheckboxColumn;
use common\models\statics\SupplierStatus;
use common\models\statics\OperationEvent;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Alert;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Supplier */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Suppliers');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$pjaxId = "supplier-pjax";
$gridId = "supplier-grid";
$alertId = "supplier-alert";
$allSelId = "supplier-all-selection";
$cleanSelId = "supplier-clear-selection";
?>
<div class="supplier-index">
    <?php
    Alert::begin([
        'id' => $alertId,
        'closeButton' => false,
        'options' => [
            'class' => 'alert alert-secondary text-center',
        ],
    ]);
    echo Html::beginTag("div", []);
    echo Html::tag("span", Yii::t("app", "<b>All {s0}</b> conversations on this page have been selected. ", ['s0' => Yii::$app->params['config']['pagination']['pageSize']]));
    echo Html::a(Yii::t("app", "Select all conversations that match this search"), "javascript:void(0)", ['id' => $allSelId]);
    echo Html::endTag("div", []);
    echo Html::beginTag("div", []);
    echo Html::tag("span", Yii::t("app", "All conversations on this page have been selected. "), []);
    echo Html::a(Yii::t("app", "clear selection."), "javascript:void(0)", ['id' => $cleanSelId]);
    echo Html::endTag("div", []);
    Alert::end();
    ?>

    <?php echo common\widgets\gridview\Toolbox::widget(); ?>

    <?php Pjax::begin(['id' => $pjaxId]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=
    GridView::widget([
        'id' => $gridId,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}\n{items}\n{pager}",
        'columns' => [
            ['class' => CheckboxColumn::class],
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'code',
//            't_status',
            [
                'attribute' => 't_status',
                'filter' => SupplierStatus::getHashMap('id', 'label'),
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getStatusLabel();
                },
            ],
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                }
//            ],
        ],
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class,
            'listOptions' => ['class' => 'pagination justify-content-end'],
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last'
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
    <?php
    Modal::begin([
        'title' => Yii::t('app', 'Which column(s) should be included?'),
        'id' => 'supplier-index-modal',
        'size' => Modal::SIZE_LARGE,
    ]);
    Modal::end();

    $js = "";
    $js .= "jQuery('#{$alertId}').hide()";
    $js .= "\n";

    $js .= "jQuery(document).on('" . OperationEvent::DATA_EXPORT . "', '.supplier-index', function(e, data) {
                    e.preventDefault();
                    var ids = jQuery('#{$gridId}').yiiGridView('getSelectedRows');
//                    if(ids.length==0){
//                        jQuery('#supplier-index-modal').modal('show').find('.modal-body').html('" . Yii::t('app', 'Hi, Please select at lease one item!') . "');
//                    }
//                    else{
//                        jQuery('#supplier-index-modal').modal('show').find('.modal-body').html('" . Yii::t('app', 'Loading...') . "').load('" . Url::toRoute('export') . "'+ '?' + jQuery.param({'ids':ids}));
//                    }
                    jQuery('#supplier-index-modal').modal('show').find('.modal-body').html('" . Yii::t('app', 'Loading...') . "').load('" . Url::toRoute('export') . "'+ '?' + jQuery.param({'ids':ids}));
                });";
    $js .= "\n";

    $js .= "jQuery(document).on('" . OperationEvent::REFRESH . "', '.supplier-index', function(e, data) {
                    e.preventDefault();
                    jQuery.pjax.reload({container: '#{$pjaxId}'});
                });";
    $js .= "\n";

    $js .= "jQuery(document).on('click', '#{$allSelId}', function(e, data) {
                    jQuery('#{$gridId}').find(\"input[name='selection[]']\").prop('checked', true);
                });";
    $js .= "\n";

    $js .= "jQuery(document).on('click', '#{$cleanSelId}', function(e, data) {
                    jQuery('#{$gridId}').find(\"input[name='selection[]']:checked\").prop('checked', false);
                });";
    $js .= "\n";

    $js .= "jQuery(document).on('click', \"#{$gridId} input[name='selection_all']\", function(e, data) {
                    jQuery('#{$alertId}').show();
                });";
    $js .= "\n";

    $js .= "jQuery(document).on('click', \"#{$gridId} input[name='selection[]']\", function(e, data) {
                    var max = jQuery('#{$gridId}').find(\"input[name='selection[]']\").length;
                    var sel = jQuery('#{$gridId}').find(\"input[name='selection[]']:checked\").length;
                    if(sel == max){
                        jQuery('#{$alertId}').show();
                    }
                });";
    $js .= "\n";

    $this->registerJs($js);
    ?>
</div>
