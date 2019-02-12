<?php

namespace backend\controllers;

use common\component\Constatnts;
use common\models\User;
use Yii;
use common\models\Menu;
use backend\models\search\SearchMenu;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
                        'roles' => [Constatnts::RBACK_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMenu();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model->scenario = Menu::SCENARIO_CREATE;
        if ($model->load(Yii::$app->request->post()) ) {
            $imgFile = UploadedFile::getInstance($model, 'img');
            $path = Yii::getAlias('@frontend') .'/web/uploads/menu/';
            if(isset($imgFile->size)) {
                if(!file_exists($path)) {
                    FileHelper::createDirectory($path);
                }
                $imgFile->saveAs($path . time() . '.' . $imgFile->extension);
                $model->img = time() . '.' . $imgFile->extension;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Menu::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post())) {

            $imgFile = UploadedFile::getInstance($model, 'img');
            if(isset($imgFile->size)) {
                $path = Yii::getAlias('@frontend') .'/web/uploads/menu/';
                if(file_exists($path.$model->img)) {
                    unlink($path.$model->img);
                }
                $imgFile->saveAs($path . time() . '.' . $imgFile->extension);
                $model->img = time() . '.' . $imgFile->extension;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(($model = Menu::findOne((int) $id))) {
            unlink(Yii::getAlias('@frontend/web') . Yii::$app->params['menuImagePath'] . $model->img);
            $model->delete();
        }
        //$this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
