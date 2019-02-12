<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 23.07.2018
 * Time: 16:55
 */
namespace frontend\controllers;

use common\models\Comments;
use common\models\Menu;
use common\models\Shops;
use common\models\StatisticMenu;
use frontend\models\ContactForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RestaurantsController extends Controller
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
                    'contacts' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        $query = Shops::find()
            ->orderBy(['id' => SORT_DESC])
            ->where(['published' => Shops::PUBLISHED]);
        $pages = $this->getPagination($query);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionView($alias, $id_cat = null)
    {
        if (empty($alias)) {
            throw new NotFoundHttpException('Не передан обязательный параметр Alias.');
        }

        $shop = Shops::findOne(['tr_name' => $alias]);
        if (empty($shop)) {
            throw new NotFoundHttpException('Такого ресторана не существует!');
        }

        $query = Menu::find()
            ->innerJoinWith('shopId')
            ->where([Shops::tableName() . '.tr_name' => HtmlPurifier::process($alias)]);
        if (!empty($id_cat)) {
            $query->andWhere(['id_cat' => (int)$id_cat]);
        }
        $pages = $this->getPagination($query);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('menu-list', [
            'model' => $model,
            'shop' => $shop,
            'pages' => $pages,
        ]);
    }

    public function actionIsChefDish($alias)
    {
        if(Yii::$app->request->isAjax) :
            $raitingDish = Menu::find()
                    ->innerJoinWith(['shopId'])->asArray()
                    ->where([Shops::tableName() . '.tr_name' => HtmlPurifier::process($alias)])
                    ->limit(4)->all();
            return $this->renderAjax('../about/commons/raiting-dish', [
                'modelMenu' => $raitingDish,
            ]);
        endif;
    }

    public function actionOpen($alias)
    {
        if (empty($alias)) {
            throw new NotFoundHttpException('Не передан обязательный параметр.');
        }
        $model = Shops::findOne(['tr_name' => $alias]);
        if (empty($model)) {
            throw new NotFoundHttpException('Такого ресторана не существует!');
        }
        $modelMenu = Menu::find()->innerJoinWith('shopId')->where([Shops::tableName() . '.tr_name' => HtmlPurifier::process($alias)])->asArray()->limit(4)->all();

        $comments = Comments::find()->where(['>', 'raiting', 3])->limit(3)->all();
        $contatModel = new ContactForm();

        if(Yii::$app->request->isPost) {
            $this->contactForm($model->email);
        }

        return $this->render('../about/view', [
            'model' => $model,
            'modelMenu' => $modelMenu,
            'comments' => $comments,
            'contatModel' => $contatModel
        ]);
    }

    protected function contactForm($email)
    {
        $modelContactForm = new ContactForm();
        if($modelContactForm->load(Yii::$app->request->post()) && $modelContactForm->validate()) {
            if ($modelContactForm->sendEmail($email)) {
                Yii::$app->session->setFlash('success', 'Спасибо Вам за обращение. В ближайщее время мы обязательно рассмотрим.');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось отправить ваше обращение. Пожалуйста обратитесь к администратору!');
            }
        }
        return $this->refresh();
    }

}