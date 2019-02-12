<?php

namespace api\controllers;

use common\models\Shops;
use yii\helpers\StringHelper;
use yii\rest\ActiveController;

class RestaurantController extends ActiveController
{

    public $modelClass = 'common\models\Shops';


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    private function substrText($text, $suffix = '...')
    {
        return StringHelper::truncate(strip_tags($text), 200, $suffix);
    }

    /**
     * Переопределенный метод
     * @return array
     */
    public function actionIndex()
    {
        $models = Shops::find()->all();
        $arr = [];
        if($models) {
            foreach ($models as $model) {
                $model->description = $this->substrText($model->description);
                $arr[] = $model;
            }
        } else {
            \Yii::$app->response->setStatusCode(404);
            $arr['msg'] = 'В базе нет ресторанов';
        }
        return $arr;
    }
}
