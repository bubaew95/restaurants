<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 02.08.2018
 * Time: 16:52
 */

namespace api\controllers;

use common\models\Menu;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RestdishesController extends Controller
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
        $id         = Yii::$app->request->post('id');
        $id_shop    = Yii::$app->request->post('id_shop');
        if(!$id_shop || !$id) {
            throw new NotFoundHttpException('Не передан обязательный параметр');
        }
        $model = Menu::find()
                    ->where(['id_shop' => (int) $id_shop])
                    ->andWhere(['!=', 'id', (int)$id])
                    ->orderBy(['id' => rand()])
                    ->limit(6)
                    ->all();
        return $model;
    }

    public function actionLikedishes()
    {
        $name = Yii::$app->request->post('name');
        $id = Yii::$app->request->post('id');
        if(!$name || !$id) {
            throw new NotFoundHttpException('Не передан обязательный параметр');
        }
        $model = Menu::find()->where(['like', 'name', ($name)])->andWhere(['!=', 'id', (int) $id])->limit(6)->all();
        return $model;
    }

}