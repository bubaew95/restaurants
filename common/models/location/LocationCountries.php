<?php

namespace common\models\location;

use Yii;

/**
 * This is the model class for table "location_countries".
 *
 * @property int $id_country
 * @property string $name Название страны
 *
 * @property LocationRegions[] $locationRegions
 * @property UserData[] $userDatas
 */
class LocationCountries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%location_countries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_country' => 'Id Country',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationRegions()
    {
        return $this->hasMany(LocationRegions::className(), ['id_country' => 'id_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDatas()
    {
        return $this->hasMany(UserData::className(), ['id_country' => 'id_country']);
    }
}
