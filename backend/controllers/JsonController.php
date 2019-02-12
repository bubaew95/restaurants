<?php

namespace backend\controllers;

use common\models\LocationCities;
use common\models\LocationRegions;

class JsonController extends \yii\web\Controller
{

    public function actionRegions()
    {
        if(\Yii::$app->request->isPost && \Yii::$app->request->isAjax) :
            $id = (int) \Yii::$app->request->post('id_country');
            $regions = LocationRegions::find()->asArray()->where(['id_country' => $id])->all();
            $option = "";
            foreach ($regions as $key => $region) {
                $option .= "<option value='{$region['id_region']}'>{$region['name']}</option>";
            }
            return $option;
        endif;
        return false;
    }

    public function actionCities()
    {
        if(\Yii::$app->request->isPost && \Yii::$app->request->isAjax) :
            $id = (int) \Yii::$app->request->post('id_region');
            $regions = LocationCities::find()->asArray()->where(['id_region' => $id])->all();
            $option = "";
            foreach ($regions as $key => $region) {
                $option .= "<option value='{$region['id_cities']}'>{$region['name']}</option>";
            }
            return $option;
        endif;
        return false;
    }

}
