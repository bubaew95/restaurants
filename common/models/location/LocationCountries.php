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

    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['name'];
        $scenarios[self::SCENARIO_CREATE] = ['id_country', 'name'];
        return $scenarios;
    }

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
            ['id_country', 'integer'],
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
