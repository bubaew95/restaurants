<?php

namespace api\controllers;

use Yii;
use common\models\Orders;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\rest\Controller;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class OrderController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['index'],
        ];

        return $behaviors;
    }

    //public $modelClass = "common\models\Orders";

    public static function getAuthTokenFromHeader()
    {
        if(Yii::$app->request->getHeaders()->get('Authorization')){
            $authHeader = Yii::$app->request->getHeaders()->get('Authorization');
            preg_match('/^Bearer\s+(.*?)$/', $authHeader, $token);
            return $token[1];
        }
        else{
            return null;
        }
    }

    public function actionIndex()
    {
        return self::getAuthTokenFromHeader();
        if(\Yii::$app->user->isGuest) {
            return ['msg' => 'GUEST'];
        } else {
            return "ID: " . \Yii::$app->user->identity->getId();
        }
    }

}
