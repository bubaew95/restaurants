<?php
/**
 * Created by PhpStorm.
 * user: Borz
 * Date: 07.05.2016
 * Time: 10:35
 */

namespace frontend\components;
use Yii;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public function init(){
        parent::init();
    }

    private function curentWeekDay()
    {
        return date("w",  mktime(0,0,0,date("m"),date("d"),date("Y")));
    }

    public function run()
    {
        switch($this->curentWeekDay()) {
            case 0:
                return '/img/banner/banner_1.jpg';
            case 1:
                return '/img/banner/banner_2.jpg';
            case 2:
                return '/img/banner/banner_3.jpg';
            case 3:
                return '/img/banner/banner_4.jpg';
            case 4:
                return '/img/banner/banner_5.jpg';
            case 5:
                return '/img/banner/banner_6.jpg';
            case 6:
                return '/img/banner/banner_7.jpg';
        }

    }

}
