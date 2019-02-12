<?php
namespace api\controllers;

use api\models\LoginForm;
use yii\base\UserException;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use api\models\User;
// use common\models\UserModel;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'dataProvider',
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'api\components\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return [
            "message" => "Everything work fine,if you need configure response format do it in config",
        ];
    }

    public function actionRegister()
    {
        $model = new User();
        $params[$model->formName()] = Yii::$app->request->post();
        $model->load($params);
        $model->setPassword($model->password);
        return $model->register();
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $params[$model->formName()] = Yii::$app->request->post();
        $model->load($params);
        if($model->login()){
            return Yii::$app->user->identity;
        }
        else{
            throw new UserException("Wrong login credential");
        }
    }

}
