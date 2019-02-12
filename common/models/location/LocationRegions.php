<?php

namespace common\models\location;

use Yii;

/**
 * This is the model class for table "location_regions".
 *
 * @property int $id_region
 * @property int $id_country ID страны
 * @property string $name Название региона
 *
 * @property LocationCities[] $locationCities
 * @property LocationCountries $country
 * @property UserData[] $userDatas
 */
class LocationRegions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%location_regions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_country', 'name'], 'required'],
            [['id_country'], 'default', 'value' => null],
            [['id_country'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => LocationCountries::className(), 'targetAttribute' => ['id_country' => 'id_country']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_region' => 'Id Region',
            'id_country' => 'Id Country',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationCities()
    {
        return $this->hasMany(LocationCities::className(), ['id_region' => 'id_region']);
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
    public function getUserDatas()
    {
        return $this->hasMany(UserData::className(), ['id_region' => 'id_region']);
    }
}
