<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 01.08.2018
 * Time: 14:49
 */

namespace api\controllers;


use common\models\LocationCities;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CityController extends Controller
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
        $id_region = \Yii::$app->request->post('id_region');
        if(!$id_region) {
            throw new NotFoundHttpException('Не передан обязательный параметр');
        }
        $model = LocationCities::find()->where(['id_region' => (int) $id_region])->all();
        if($model == null) {
            throw new NotFoundHttpException('Город не найден');
        }
        return $model;
    }

}