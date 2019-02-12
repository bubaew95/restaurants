<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 26.07.2018
 * Time: 16:31
 */

namespace frontend\controllers;

use common\models\AddressDelivery;
use common\models\Menu;
use common\models\Orders;
use common\models\User;
use common\models\UserData;
use frontend\models\CartForm;
use frontend\models\CheckoutForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{

    /**
     * Ввывод корзины
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        return $this->render('index', [
            'session' => $session,
        ]);
    }

    public function actionCheckout()
    {
        $session = Yii::$app->session;
        $session->open();

        if (!$session['cart']) {
            return $this->goHome();
        }

        $model = new CheckoutForm();

        if(Yii::$app->request->isPost) {
            if(Yii::$app->user->isGuest) {
                $this->handleNoAuth($session, $model);
            } else {
                $this->handleAuth($session, $model);
            }
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }

    private function handleAuth($session, CheckoutForm $model)
    {
        $model->id_user = Yii::$app->user->identity->getId();
        $model->scenario = CheckoutForm::SCENARIO_AUTH;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $this->addItemsCartDb($session, $model);
                $this->clearCart();
                Yii::$app->session->addFlash('success',
                    'Ваш заказ отправлен на обработку.
                                    В скором времени с Вами свяжется наш менеджер. 
                                    Спасибо Вам за покупку!');
                return $this->goHome();
            }
        }
    }

    private function handleNoAuth($session, CheckoutForm $model)
    {
        $model->scenario = CheckoutForm::SCENARIO_NO_AUTH;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->id_user = $this->insertUser($model);
                $this->insertUserData($model);
                $model->id_address_del = $this->insertDeliveryAddress($model);

                $this->addItemsCartDb($session, $model);
                $this->clearCart();
                Yii::$app->session->addFlash('success',
                    'Ваш заказ отправлен на обработку.
                                    В скором времени с Вами свяжется наш менеджер. 
                                    Спасибо Вам за покупку!');
                return $this->goHome();
            }
        }
    }

    //Адрес заказчика
    protected function insertDeliveryAddress(CheckoutForm $model)
    {
        //Адрес доставки для пользователя
        $addressDelivery                = new AddressDelivery();
        $addressDelivery->id_user       = $model->id_user;
        $addressDelivery->id_country    = $model->id_country;
        $addressDelivery->id_region     = $model->id_region;
        $addressDelivery->id_city       = $model->id_city;
        $addressDelivery->address       = $model->address;
        $addressDelivery->save();
        return $addressDelivery->id;
    }

    //Дополнительная информации о пользователе
    protected function insertUserData(CheckoutForm $model) {
        //Дополнительные данные о пользователе
        $userData           = new UserData();
        $userData->fio      = $model->fio;
        $userData->id_user  = $model->id_user;
        $userData->phone    = $model->phone;
        return $userData->save();
    }

    //Заполнение информации о пользователе
    protected function insertUser(CheckoutForm $model)
    {
        $user = new User();
        $user->generateAuthKey();
        $user->email = $model->email;
        $user->save();
        return $user->id;
    }

    //Добавление заказов из сессию в базу
    protected function addItemsCartDb($session, CheckoutForm $modelForm)
    {
        foreach ($session['cart'] as $id => $cart) {
            $model                  = new Orders();
            $model->id_delivery     = $modelForm->id_delivery;
            $model->id_menu         = $id;
            $model->id_address_delivery = $modelForm->id_address_del;
            $model->qty             = $cart['qty'];
            $model->id_shop         = $cart['id_shop'];
            $model->id_status       = 1;
            $model->price           = $cart['price'];
            $model->id_user         = $modelForm->id_user;
            $model->save();
        }
    }

    /**
     * Добавить в корзину
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionAddtocart()
    {
        if(Yii::$app->request->isPost) {
            $model = new CartForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()) {

                $modelMenu = Menu::findOne(['id' => $model->id_menu]);
                if(!$modelMenu) {
                    throw new NotFoundHttpException('Нет такого блюда!');
                }

                $model->id_shop = $modelMenu->id_shop;
                $model->price = $modelMenu->price;
                $model->name = $modelMenu->name;
                $model->img = $modelMenu->img;
                $model->alias = $modelMenu->created_at;

                $this->AddToSessionCart($model);

                if(Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['code' => 200];
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    protected function clearCart()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.totalQty');
        $session->remove('cart.totalSum');
    }
    /**
     * Очистить корзину
     */
    public function actionClearitems()
    {
        $this->clearCart();
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['code' => 200];
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Удаление одного меню
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionItemdelete()
    {
        $id = (int) Yii::$app->request->get('id');
        if(!$id) {
            throw new NotFoundHttpException('Нет такого блюда!');
        }
        $this->recalc($id);
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['code' => 200];
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Добавить продукт в сессию
     * @param $model
     */
    protected function AddToSessionCart($model)
    {
        $session = Yii::$app->session;
        $session->open();
        if(isset($_SESSION['cart'][$model->id_menu])) {
            $_SESSION['cart'][$model->id_menu]['qty'] += $model->qty;
        } else {
            $_SESSION['cart'][$model->id_menu] = [
                'qty' => $model->qty,
                'name' => $model->name,
                'price' => $model->price,
                'alias' => $model->alias,
                'image' => $model->img,
                'id_shop' => $model->id_shop
            ];
        }
        $this->totalQtySumm($model->price, $model->qty);
    }

    /**
     * Общая сумма и общее кол-во
     * @param $price
     * @param $qty
     */
    protected function totalQtySumm($price, $qty)
    {
        $_SESSION['cart.totalQty'] = isset($_SESSION['cart.totalQty'])
            ? $_SESSION['cart.totalQty'] + $qty
            : $qty;

        $_SESSION['cart.totalSum'] = isset($_SESSION['cart.totalSum'])
            ? $_SESSION['cart.totalSum'] + $qty * $price
            : $qty * $price;
    }

    /**
     * Перерасчет
     * @param $id
     * @return bool
     */
    protected function recalc($id)
    {
        $session = Yii::$app->session;
        $session->open();
        if(!isset($_SESSION['cart'][$id])) return false;
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.totalQty'] -= $qtyMinus;
        $_SESSION['cart.totalSum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }

}