<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 31.07.2018
 * Time: 15:49
 */

namespace api\controllers;

use common\models\User;
use Yii;
use frontend\models\SignupForm;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\HttpException;

class UserController extends ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['create'],
        ];
        $behaviors['authenticator']['auth'] = function ($email, $password) {
             $user = User::findOne(['email' => $email, 'password_reset_token' => null]);
             if($user && $user->validatePassword($password)) {
                 return $user;
             }
             return null;
        };

        return $behaviors;
    }

    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        // отключить действия "delete" и "create"
        unset (
            $actions['index'],
            $actions['create'],
            $actions['delete'],
            $actions['update']
        );
        return $actions;
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password_hash'], $fields['auth_key']);
        return $fields;
    }

    /**
     * Получение Token
     * @return string
     */
    public function actionIndex()
    {
        return Yii::$app->user->identity->getAuthKey();
    }

    /**
     * Переопределнный медот
     * Создания пользователя
     * @return \common\models\User|null
     * @throws HttpException
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $model->id_country  = 3159;
        $model->id_region   = 5543;
        $model->id_city     = 5545;
        if($model->load(Yii::$app->request->post(), '')) {
            if($model->validate()) {
                return $model->signup();
            } else {
                Yii::$app->response->setStatusCode(404);
                $arr= [];
                foreach ($model->errors as $error) {
                    $arr[] = $error;
                }
                return $arr;
            }
        }
    }

}