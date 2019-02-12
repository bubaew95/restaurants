<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 05.08.2018
 * Time: 16:29
 */

namespace frontend\controllers;

use common\models\AddressDelivery;
use frontend\models\CheckoutForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AddressController extends Controller
{

    public function actionAddform()
    {
        if(Yii::$app->request->isAjax) {
            $model = new CheckoutForm();
            $model->scenario = CheckoutForm::SCENARIO_NEWADDRESS;
            return $this->renderAjax('add', compact('model'));
        }
    }

    public function actionAddaddress()
    {
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new CheckoutForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->scenario = CheckoutForm::SCENARIO_NEWADDRESS;
                $addressModel = new AddressDelivery();
                $addressModel->id_country = $model->id_country;
                $addressModel->id_region = $model->id_region;
                $addressModel->id_city = $model->id_city;
                $addressModel->address = $model->address;
                $addressModel->id_user = Yii::$app->user->identity->getId();
                if($addressModel->save()) {
                    return ['code' => 200];
                }
                return ['code' => 404];
            }
        }
    }

}