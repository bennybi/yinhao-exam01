<?php

use yii\helpers\Html;
use yii\bootstrap4\ButtonGroup;
?>

<?php

echo ButtonGroup::widget([
    "id" => "{$this->context->id}-btn-groups",
    "options" => [
        "class" => "float-right",
    ],
    "buttons" => $this->context->getButtons(),
]);

echo Html::tag("div", "", ["class" => "clearfix"]);
