<?php

namespace api\controllers;

use Yii;
use common\models\Menu;
use yii\rest\ActiveController;
use yii\web\Controller;

class MenuController extends ActiveController
{

   public $modelClass = 'common\models\Menu';

}
