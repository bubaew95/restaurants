<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;

class AuthController extends Controller
{

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

}
