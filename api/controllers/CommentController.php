<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 02.08.2018
 * Time: 18:17
 */

namespace api\controllers;

use common\models\Comments;
use common\models\User;
use common\models\UserData;
use frontend\models\CommentsForm;
use Yii;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    //public $modelClass = 'common\models\Comments';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        header("access-control-allow-origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    public function actionIndex()
    {
        $id = Yii::$app->request->post('id');
        if(!$id) {
            throw new NotFoundHttpException('Не передан обязательный параметр');
        }
        $comments =  Comments::find()
                        ->select([Comments::tableName() . '.*', UserData::tableName() . '.fio'])
                        ->innerJoinWith('userData')
                        ->where([Comments::tableName() . '.id_menu' => (int) $id])
                        ->orderBy([Comments::tableName() . '.id' => SORT_DESC])
                        ->asArray()
                        ->all();
        if($comments) {
            return $comments;
        }
        throw new NotFoundHttpException('Нет данных');
    }
}