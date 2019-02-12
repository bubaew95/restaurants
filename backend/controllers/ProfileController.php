<?php

namespace backend\controllers;

use common\models\AddressDelivery;
use Yii;
use common\models\User;
use common\models\UserData;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id_user = \Yii::$app->user->identity->getId();
        $modelUser = User::userInfo($id_user);
        $modelUserData = UserData::userDataInfo($id_user);
        $modelAddress = AddressDelivery::deliveryInfo($id_user);

        if($modelUser->load(Yii::$app->request->post()) &&
            $modelUserData->load(Yii::$app->request->post()) &&
            $modelAddress->load(Yii::$app->request->post())) {
            if($modelUser->save() && $modelUserData->save() && $modelAddress->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'modelUser' => $modelUser,
            'modelUserData' => $modelUserData,
            'modelAddress' => $modelAddress
        ]);
    }

}
