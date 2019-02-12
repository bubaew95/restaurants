<?php

namespace backend\controllers;

use backend\models\search\SliderTextSearch;
use common\component\Constatnts;
use common\models\slider\SliderText;
use Imagine\Image\Box;
use Yii;
use common\models\slider\SliderImg;
use backend\models\search\SliderImgSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * SliderController implements the CRUD actions for SliderImg model.
 */
class SliderController extends Controller
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
     * Lists all SliderImg models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderImgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SliderImg model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new SliderTextSearch();
        $searchModel->idSlider = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SliderImg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SliderImg();

        if ($model->load(Yii::$app->request->post())) {

            $imgFile = UploadedFile::getInstance($model, 'image');
            $path = Yii::getAlias('@frontend') .'/web/' . Yii::$app->params['sliderImagePath'] . $model->shop->tr_name.'/';
            if(!file_exists($path)) {
                mkdir($path, 0775, true);
            }
            if(isset($imgFile->size)) {
                $fileName = time() . '.' . $imgFile->extension;
                $imgFile->saveAs($path . time() . '.' . $imgFile->extension);
                Image::thumbnail($path . $fileName, 1920, 500)
                    ->resize(new Box(1920,500))
                    ->save($path  . $fileName, ['quality' => 80]);
                $model->image = $model->shop->tr_name .'/' .$fileName;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SliderImg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $imgFile = UploadedFile::getInstance($model, 'image');
            $model->image = $model->img;
            if(isset($imgFile->size)) {
                $path = Yii::getAlias('@frontend') .'/web/' . Yii::$app->params['sliderImagePath'] . $model->shop->tr_name.'/';
                if(file_exists($path . $model->image)) {
                    unlink($path . $model->image);
                }
                $fileName = time() . '.' . $imgFile->extension;
                $imgFile->saveAs($path . $fileName);
                Image::thumbnail($path . $fileName, 1920, 500)
                    ->resize(new Box(1920,500))
                    ->save($path  . $fileName, ['quality' => 80]);
                $model->image = $model->shop->tr_name .'/' . $fileName;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SliderImg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SliderImg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SliderImg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SliderImg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
