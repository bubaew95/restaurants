<?php

namespace frontend\controllers;

use common\models\Pages;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class PageController extends \yii\web\Controller
{
    public function actionView($alias)
    {
        if (empty($alias)) {
            throw new NotFoundHttpException('Не передан один из обязательных параметров Id|Alias.');
        }
        $model = Pages::findOne(['tr_name' => Html::encode($alias)]);
        return $this->render('view', [
            'model' => $model
        ]);
    }

}
