<?php

namespace common\widgets\gridview;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use common\models\statics\OperationEvent;
use yii\helpers\Url;

/**
 * 
 * @author Ben Bi <bennybi@qq.com>
 */
class Toolbox extends Widget {

    public $options = [];
    public $template;

    public function init() {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->template = "Toolbox";
    }

    public function getButtons() {
        return [
            ["id" => "{$this->id}-export", "label" => Yii::t("app", "Export"), "options" => [
                    "class" => "btn-primary",
                    'onclick' => "jQuery(this).trigger('" . OperationEvent::DATA_EXPORT . "', {url:'" . Url::toRoute('export') . "'});"]],
//            ["id" => "{$this->id}-refresh", "label" => Yii::t("app", "Refresh"), "options" => [
//                    "class" => "btn-secondary",
//                    'onclick' => "jQuery(this).trigger('" . OperationEvent::REFRESH . "');",]],
        ];
    }

    public function run() {
        return $this->render($this->template);
    }

}
