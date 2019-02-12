<?php

namespace api\controllers;

use common\models\AddressDelivery;
use common\models\Orders;
use common\models\User;
use common\models\UserData;
use frontend\models\CheckoutForm;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\HttpException;

class CheckorderController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    /**
     * Создание заказа из мобильного приложения
     * @return CheckoutForm|void
     * @throws HttpException
     */
    public function actionCreate()
    {
        $model              = new CheckoutForm();
        $model->scenario    = CheckoutForm::SCENARIO_MOBILE;
        $model->id_user     = Yii::$app->user->identity->getId();
        if($model->load(Yii::$app->request->post(), '')) {
            if($model->validate()) {
                return $this->addItemsCartDb($model);
            } else {
                Yii::$app->response->setStatusCode(404);
                return $model->errors;
            }
        }
    }

    /**
     * Добавление данных заказчика
     * Сформирование адреса
     * @param CheckoutForm $model
     */
    private function handleNoAuth(CheckoutForm $model)
    {
        $model->id_user = $this->insertUser($model);
        $this->insertUserData($model);
        $model->id_address_del = $this->insertDeliveryAddress($model);
        return $this->addItemsCartDb($model);
    }

    /**
     * Адрес заказчика
     * @param CheckoutForm $model
     * @return mixed
     */
    protected function insertDeliveryAddress(CheckoutForm $model)
    {
        $addressDelivery                = new AddressDelivery();
        $addressDelivery->id_user       = $model->id_user;
        $addressDelivery->id_country    = $model->id_country;
        $addressDelivery->id_region     = $model->id_region;
        $addressDelivery->id_city       = $model->id_city;
        $addressDelivery->address       = $model->address;
        $addressDelivery->save();
        return $addressDelivery->id;
    }

    /**
     * Дополнительная информации о пользователе
     * @param CheckoutForm $model
     * @return mixed
     */
    protected function insertUserData(CheckoutForm $model)
    {
        $userData           = new UserData();
        $userData->fio      = $model->fio;
        $userData->id_user  = $model->id_user;
        $userData->phone    = $model->phone;
        return $userData->save();
    }

    /**
     * Заполнение информации о пользователе
     * @param CheckoutForm $model
     * @return int
     */
    protected function insertUser(CheckoutForm $model)
    {
        $user = new User();
        $user->generateAuthKey();
        $user->email = $model->email;
        $user->save();
        return $user->id;
    }

    //Добавление заказов из сессию в базу
    protected function addItemsCartDb(CheckoutForm $modelForm)
    {
        foreach ($modelForm->dataItems as $id => $cart) {
            $model                      = new Orders();
            $model->id_delivery         = $modelForm->id_delivery;
            $model->id_address_delivery = $modelForm->id_address_del;
            $model->id_user             = $modelForm->id_user;
            $model->id_status           = 1;
            $model->id_menu             = $cart['id_menu'];
            $model->qty                 = $cart['qty'];
            $model->id_shop             = $cart['id_shop'];
            $model->price               = $cart['price'];
            $model->save();
        }
        Yii::$app->response->setStatusCode(200);
        return ['msg' => 'Success'];
    }

}
