<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 31.07.2018
 * Time: 15:34
 */

namespace api\controllers;


use yii\rest\ActiveController;

class CountryController extends ActiveController
{

    public $modelClass = 'common\models\LocationCountries';

}