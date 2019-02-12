<?php

namespace api\controllers;

use common\models\AddressDelivery;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class UserAddressController extends ActiveController
{
    public $modelClass = 'common\models\AddressDelivery';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $id_user = Yii::$app->user->identity->getId() ?? 0;
        $model = AddressDelivery::find()->where(['id_user' => $id_user])->all();
        return $model;
    }

}
