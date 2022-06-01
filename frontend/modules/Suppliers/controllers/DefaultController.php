<?php

namespace frontend\modules\Suppliers\controllers;

use Yii;
use common\models\entity\Supplier;
use common\models\search\Supplier as SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use frontend\models\forms\ExportForm;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for Supplier model.
 */
class DefaultController extends Controller {

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex() {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionExport() {
        $model = new ExportForm(['entityModelClass' => Supplier::class]);
        if (Yii::$app->request->isAjax) {
            $model->ids = implode(',', Yii::$app->request->getQueryParam("ids") ?? []);
            return $this->renderAjax('export', ['model' => $model,]);
        } elseif ($model->load(Yii::$app->request->post())) {
            Yii::info($model->ids);
            $content = "";
            $type = "csv";
            $name = "suppliers_" . date("YmdHi");
            $mime = "text/plain";
            $encoding = 'utf-8';
            $this->setHttpHeaders($type, $name, $mime, $encoding);

            if ($model->ids) {
                $ids = explode(",", $model->ids);
                $list = Supplier::find()->where(['id' => $ids])->select(ArrayHelper::merge(['id'], $model->columns))->asArray()->all();
                $content = $this->array2csv($list);
            } else {
                $list = Supplier::find()->where([])->select(ArrayHelper::merge(['id'], $model->columns))->asArray()->all();
                $content = $this->array2csv($list);
            }
            return $content;
        }
    }

    public function array2csv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\") {
        $f = fopen('php://memory', 'r+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    /**
     * Sets the HTTP headers needed by file download action.
     *
     * @param string $type the file type
     * @param string $name the file name
     * @param string $mime the mime time for the file
     * @param string $encoding the encoding for the file content
     *
     * @return void
     */
    protected function setHttpHeaders($type, $name, $mime, $encoding = 'utf-8') {
        Yii::$app->response->format = Response::FORMAT_RAW;
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") == false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        } else {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
        }
        header("Expires: Sat, 26 Jul 1979 05:00:00 GMT");
        header("Content-Encoding: {$encoding}");
        header("Content-Type: {$mime}; charset={$encoding}");
        header("Content-Disposition: attachment; filename={$name}.{$type}");
        header("Cache-Control: max-age=0");
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
