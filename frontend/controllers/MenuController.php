<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 24.07.2018
 * Time: 13:16
 */

namespace frontend\controllers;
use common\models\Menu;
use common\models\Orders;
use common\models\Shops;
use frontend\models\CartForm;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class MenuController extends \yii\web\Controller
{

    //Пагинация
    public static function getPagination($query = null)
    {
        $pages = new Pagination([
            'forcePageParam' => false,
            'pageSizeParam' => false,
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->params['pageCount']
        ]);
        return $pages;
    }

    public function actionIndex($id_cat = null)
    {
        $query = Menu::find();
        if(!empty($id_cat)) {
            $query->andWhere(['id_cat' =>  (int) $id_cat]);
        }
        $pages = $this->getPagination($query);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('../restaurants/menu-list', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionView($alias, $id)
    {
        if (empty($alias) || empty($id)) {
            throw new NotFoundHttpException('Не передан один из обязательных параметров Id|Alias.');
        }

        $model = Menu::find()->where([Menu::tableName() . '.id' => (int) $id])->one();//findOne(['id' => (int) $id]);
        $modelCart = new CartForm();
        if (empty($model)) {
            throw new NotFoundHttpException('Такого блюда не существует!');
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('modal-view', [
                'model' => $model,
                'modelCart' => $modelCart,
            ]);
        }

        return $this->render('view', [
            'model' => $model,
            'modelCart' => $modelCart,
        ]);
    }



}