<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 31.07.2018
 * Time: 15:54
 */

namespace api\controllers;


use common\models\LocationRegions;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RegionController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        header("access-control-allow-origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    public function actionIndex()
    {
        $id_country = \Yii::$app->request->post('id_country');
        if(!$id_country) {
            throw new NotFoundHttpException('Не передан обязательный параметр');
        }
        $model = LocationRegions::find()->where(['id_country' => (int) $id_country])->all();
        if($model == null) {
            throw new NotFoundHttpException('Регион не найден');
        }
        return $model;
    }


}