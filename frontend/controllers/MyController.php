<?php

namespace frontend\controllers;

use common\models\Comments;
use frontend\models\CommentsForm;
use Yii;
use common\models\Orders;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MyController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionOrdersHistory()
    {
        $model = Orders::find()->with(['menu', 'status'])->where(['id_user' => (int) Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);

        return $this->render('orders-history', [
            'model' => $dataProvider
        ]);
    }


    public function actionAddComment($id)
    {

        if(Yii::$app->request->isAjax) {
            if (empty($id)) {
                throw new NotFoundHttpException('Не передан обязательный параметр ID');
            }
            $model = new CommentsForm();
            if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($model->validate()) {
                    $model->id_menu = $id;
                    $model->id_user = Yii::$app->user->identity->getId();
                    return $this->insertComm($model);
                }
                return ['code' => 404, 'errors' => $model->errors];
            }

            return $this->renderAjax('add-comment', compact('model'));
        }
    }

    protected function insertComm(CommentsForm $model)
    {
        $modelComm              = new Comments();
        $modelComm->id_user     = $model->id_user;
        $modelComm->id_menu     = $model->id_menu;
        $modelComm->text        = $model->text;
        $modelComm->raiting     = $model->raiting;
        return $modelComm->save() ? ['code' => 200] : ['code' => 404, 'errors' => $model->errors];
    }
}
