<?php

namespace frontend\modules\Suppliers\controllers;

use Yii;
use common\models\entity\Supplier;
use common\models\search\Supplier as SupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

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
        $ids = Yii::$app->request->getQueryParam("ids");
        $content = "";
        if ($ids) {
            $type = "csv";
            $name = "suppliers_" . date("YmdHi");
            $mime = "text/plain";
            $encoding = 'utf-8';
            $this->setHttpHeaders($type, $name, $mime, $encoding);
            $list = Supplier::find()->where(['id' => $ids])->asArray()->all();
            $content = $this->array2csv($list);
        }
        return $content;
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

//    /**
//     * Creates a new Supplier model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return string|\yii\web\Response
//     */
//    public function actionCreate() {
//        $model = new Supplier();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }
//
//    /**
//     * Updates an existing Supplier model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param int $id ID
//     * @return string|\yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id) {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Supplier model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param int $id ID
//     * @return \yii\web\Response
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id) {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

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
