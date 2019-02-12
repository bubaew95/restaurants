<?php

namespace backend\controllers;

use Yii;
use common\models\SliderText;
use backend\models\search\SliderTextSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SlideritemsController implements the CRUD actions for SliderText model.
 */
class SlideritemsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SliderText models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderTextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/slideritems/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SliderText model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateItems($id)
    {
        $model = new SliderText();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->validate()) {
                $model->id_slider = $id;
                if(!empty($model->classes)) $model->setClasses($model->classes);
                if ($model->save())
                    return ['code' => 200];
                //return $this->redirect(['view', 'id' => $model->id]);
            }
            return $model->errors;
        }

        return $this->renderAjax('../slider/_form_items', [
            'model' => $model,
        ]);
    }

    public function actionUpdateItems($id, $id_slider)
    {
        $model = SliderText::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->validate()) {
                $model->id_slider = $id_slider;
                if(!empty($model->classes)) $model->setClasses($model->classes);
                if ($model->save())
                    return ['code' => 200];
                //return $this->redirect(['view', 'id' => $model->id]);
            }
            return $model->errors;
        }

        return $this->renderAjax('../slider/_form_items', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SliderText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteItems($id)
    {
        if($this->findModel((int) $id)->delete()) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['code' => 200];
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the SliderText model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SliderText the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SliderText::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
