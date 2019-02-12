<?php

namespace backend\controllers;

use common\component\Constatnts;
use Imagine\Gd\Image;
use Imagine\Image\Box;
use Yii;
use common\models\Shops;
use backend\models\search\SearchShops;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;


/**
 * ShopsController implements the CRUD actions for Shops model.
 */
class ShopsController extends Controller
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
     * Lists all Shops models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchShops();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shops model.
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
     * Creates a new Shops model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shops();

        if ($model->load(Yii::$app->request->post())) {

            $imgFile = UploadedFile::getInstance($model, 'logo');
            $path = Yii::getAlias('@frontend') .'/web/uploads/restaurants/';
            if(isset($imgFile->size)) {
                if(!file_exists($path)) {
                    FileHelper::createDirectory($path);
                }
                $fileName = createAlias($model->name) . '.' . $imgFile->extension;
                $imgFile->saveAs($path . $fileName);
                Image::thumbnail($path . $fileName, 400, 200)
                    ->resize(new Box(400,200))
                    ->save($path  . $fileName, ['quality' => 70]);
                $model->logo = $fileName;
            }
            if(!Yii::$app->user->can(Constatnts::RBACK_ADMIN)) {
                $model->id_manager = Yii::$app->user->identity->getId();
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Shops model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel((int) $id);
        if ($model->load(Yii::$app->request->post())) {
            $imgFile = UploadedFile::getInstance($model, 'logo');
            $model->logo = $model->img_logo;
            if(isset($imgFile->size)) {
                $path = Yii::getAlias('@frontend') .'/web/uploads/restaurants/';
                if(file_exists($path . $model->logo)) {
                    unlink($path . $model->logo);
                }
                $fileName = createAlias($model->name) . '.' . $imgFile->extension;
                $imgFile->saveAs($path . $fileName);
                Image::thumbnail($path . $fileName, 400, 200)
                    ->resize(new Box(400,200))
                    ->save($path  . $fileName, ['quality' => 70]);
                $model->logo = $fileName;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Shops model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can(Constatnts::RBACK_ADMIN)) {
            Yii::$app->session->setFlash('error', 'Только администратор может удалить ресторан!');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if(($model = Shops::findOne((int) $id))) {
            unlink(Yii::getAlias('@frontend/web') . Yii::$app->params['restaurantImagePath'] . $model->logo);
            $model->delete();
        }
        //$this->findModel((int) $id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Shops model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shops the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $id_user = Yii::$app->user->identity->getId();
        $model = Shops::findOne(['id' => $id, 'id_manager' => (int) $id_user]);
        if(Yii::$app->user->can(Constatnts::RBACK_ADMIN)) {
            $model = Shops::findOne($id);
        }
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
