<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "borz_address_delivery".
 *
 * @property int $id
 * @property int $id_user Пользователь
 * @property int $id_country Страна
 * @property int $id_region Регион
 * @property int $id_city Город
 * @property string $address Адрес
 *
 * @property LocationCities $city
 * @property LocationCountries $country
 * @property LocationRegions $region
 * @property User $user
 * @property Orders[] $orders
 */
class AddressDelivery extends \yii\db\ActiveRecord
{

    const SCENARIO_DEFAULT =  'default';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['id_user', 'id_country', 'id_region', 'id_city', 'address'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address_delivery}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_country', 'id_region', 'id_city', 'address'], 'required'],
            [['id_user', 'id_country', 'id_region', 'id_city'], 'default', 'value' => null],
            [['id_user', 'id_country', 'id_region', 'id_city'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => LocationCities::className(), 'targetAttribute' => ['id_city' => 'id_cities']],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => LocationCountries::className(), 'targetAttribute' => ['id_country' => 'id_country']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => LocationRegions::className(), 'targetAttribute' => ['id_region' => 'id_region']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'id_user'       => 'Пользователь',
            'id_country'    => 'Страна',
            'id_region'     => 'Регион',
            'id_city'       => 'Город',
            'address'       => 'Адресс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(LocationCities::className(), ['id_cities' => 'id_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(LocationCountries::className(), ['id_country' => 'id_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(LocationRegions::className(), ['id_region' => 'id_region']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['id_address_delivery' => 'id']);
    }

    public function deliveryInfo($id_user)
    {
        return static::findOne(['id_user' => $id_user]);
    }
}
