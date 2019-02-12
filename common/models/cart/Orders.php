<?php

namespace common\models\cart;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $id_menu ID продукта
 * @property int $id_address_delivery ID Адреса доставки
 * @property int $id_delivery ID доставки
 * @property int $qty Кол-во
 * @property int $id_shop ID Магазина
 * @property int $id_status ID статус
 * @property int $id_transport ID транпорта
 * @property string $price Цена
 * @property int $id_user ID заказчика
 *
 * @property Cart $card
 * @property Menu $menu
 * @property Shops $shop
 * @property Status $status
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    public $allprice;
    public $address;

    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['id_delivery'];
        $scenarios[self::SCENARIO_CREATE] = ['id_menu', 'id_delivery', 'id_address_delivery', 'qty', 'id_shop', 'id_status', 'id_transport', 'id_user'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_delivery'], 'required'],
            [['id_menu', 'id_delivery', 'id_address_delivery', 'qty', 'id_shop', 'id_status', 'id_transport', 'id_user'], 'default', 'value' => null],
            [['id_menu', 'id_delivery', 'id_address_delivery', 'qty', 'id_shop', 'id_status', 'id_transport', 'id_user'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'integer', 'min' => 1],
            [['created_at', 'updated_at'], 'safe'],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
            [['id_shop'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_delivery'], 'exist', 'skipOnError' => true, 'targetClass' => Delivery::className(), 'targetAttribute' => ['id_delivery' => 'id']],
            [['id_address_delivery'], 'exist', 'skipOnError' => true, 'targetClass' => AddressDelivery::className(), 'targetAttribute' => ['id_address_delivery' => 'id']],
        ];
    }

    public function behaviors(){
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'qty'                   => 'Кол-во',
            'price'                 => 'Цена',
            'id_shop'               => 'Ресторан',
            'id_user'               => 'Заказчик',
            'address'               => 'Адрес',
            'id_menu'               => 'Меню',
            'allprice'              => 'Общая сумма',
            'id_status'             => 'Статус',
            'id_delivery'           => 'Способ доставки',
            'id_transport'          => 'Курьер',
            'id_address_delivery'   => 'Адрес доставки',
            'created_at'            => 'Дата заказа',
            'updated_at'            => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Cart::className(), ['id' => 'id_address_delivery']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'id_menu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'id_status']);
    }

    public function getUserShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop'])
            ->where([Shops::tableName() . '.id_manager' => Yii::$app->user->identity->getId()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getAddressDelivery()
    {
        return $this->hasOne(AddressDelivery::className(), ['id' => 'id_address_delivery']);
    }

    public function getDelivery()
    {
        return $this->hasOne(Delivery::className(), ['id' => 'id_delivery']);
    }


}
