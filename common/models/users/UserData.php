<?php

namespace common\models\users;

use Yii;

/**
 * This is the model class for table "user_data".
 *
 * @property int $id
 * @property string $fio ФИО
 * @property string $phone Номер телефона
 * @property int $id_user ID пользователя
 * @property string $birthday Дата рождения
 * @property int $ip_address IP адрес
 * @property int $index Почтовый индекс
 * @property string $user_agent Браузер пользователя
 *
 * @property LocationCities $city
 * @property LocationCountries $country
 * @property LocationRegions $region
 */
class UserData extends \yii\db\ActiveRecord
{

    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['fio', 'phone', 'birthday'];
        $scenarios[self::SCENARIO_CREATE] = ['fio', 'id_user', 'phone', 'ip_address', 'birthday'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'id_user', 'phone'], 'required'],
            [['id_user', 'ip_address'], 'default', 'value' => null],
            [['id_user', 'ip_address'], 'integer'],
            [['birthday'], 'safe'],
            [['fio', 'user_agent'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'fio'           => 'Ф.И.О',
            'phone'         => 'Телефон',
            'id_user'       => 'Пользователь',
            'birthday'      => 'День рождение',
            'ip_address'    => 'IP',
            'user_agent'    => 'user Agent',
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

    public function userDataInfo($id_user)
    {
        return static::findOne(['id_user' => (int) $id_user]);
    }
}
