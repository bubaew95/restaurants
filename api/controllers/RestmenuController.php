<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 02.08.2018
 * Time: 16:52
 */

namespace api\controllers;

use Yii;
use common\models\Menu;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class RestmenuController extends ActiveController
{

    public $modelClass = 'common\models\Menu';
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionView($id)
    {
        if(!$id) {
            Yii::$app->response->setStatusCode(404);
            return [
                'message' => 'Не передан обязательный параметр'
            ];
        }
        if(($model = Menu::find()->where(['id_shop' => (int) $id])->all()))
            return $model;
        Yii::$app->response->setStatusCode(404);
        return ['msg' => 'В базе нет блюд'];
    }

}