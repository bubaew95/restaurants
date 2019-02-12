<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 26.07.2018
 * Time: 15:12
 */

namespace frontend\models;


use common\models\Menu;
use common\models\Shops;
use yii\base\Model;

class CartForm extends Model
{
    public $id_menu;
    public $id_shop;
    public $qty;
    public $alias;
    public $price;
    public $name;
    public $img;

    public function rules()
    {
        return [
            [['id_menu', 'id_shop', 'qty'], 'required'],
            [['price', 'name', 'img', 'alias'], 'safe'],
            [['id_menu', 'id_shop', 'qty'], 'integer', 'min' => 1],
            ['id_menu', 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
            ['id_shop', 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
            [['price'], 'double'],
        ];
    }

}