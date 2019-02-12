<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 05.08.2018
 * Time: 13:24
 */

namespace frontend\models;


use common\models\User;
use yii\base\Model;

class CheckoutForm extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $id_country;
    public $id_region;
    public $id_city;
    public $address;
    public $id_delivery;
    public $id_address_del;
    public $id_user;
    public $dataItems;

    const SCENARIO_AUTH = 'auth';
    const SCENARIO_NO_AUTH = 'no-auth';
    const SCENARIO_NEWADDRESS = 'new-address';
    const SCENARIO_MOBILE = 'mobile-app';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_AUTH] = ['id_delivery', 'id_address_del', 'id_user'];
        $scenarios[self::SCENARIO_NO_AUTH] = ['fio', 'email', 'phone', 'id_country', 'id_region', 'id_city', 'address', 'id_delivery'];
        $scenarios[self::SCENARIO_MOBILE] = ['id_delivery', 'id_address_del', 'id_user', 'dataItems'];
        $scenarios[self::SCENARIO_NEWADDRESS] = ['id_country', 'id_region', 'id_city', 'address'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['id_delivery', 'id_address_del', 'id_user'], 'required', 'on' => self::SCENARIO_AUTH],
            [['id_country', 'id_region', 'id_city', 'address'], 'required', 'on' => self::SCENARIO_NEWADDRESS],
            [['fio', 'email', 'phone', 'id_country', 'id_region', 'id_city', 'address', 'id_delivery'], 'required', 'on' => self::SCENARIO_NO_AUTH],
            [['id_delivery', 'id_address_del', 'id_user', 'dataItems'], 'required', 'on' => self::SCENARIO_MOBILE],

            [['id_user', 'id_address_del'], 'safe'],
            [['id_country', 'id_region', 'id_city', 'id_delivery', 'id_user', 'id_address_del'], 'integer', 'min' => 1],
            [['fio', 'address'], 'string'],
            ['email', 'email'],
            ['email', 'isEmail']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user'       => 'Пользователь',
            'id_country'    => 'Страна',
            'id_region'     => 'Регион',
            'id_city'       => 'Город',
            'address'       => 'Адресс',
            'fio'           => 'Ф.И.О',
            'phone'         => 'Телефон',
            'id_address_del' => 'Адрес доставки',
            'id_delivery'   => 'Способ доставки',
        ];
    }

    public function isEmail()
    {
        if(!$this->hasErrors()) {
            if(User::findOne(['email' => $this->email])) {
                $this->addError('email', 'Такой емайл уже сущетвует!');
            }
        }
    }

}