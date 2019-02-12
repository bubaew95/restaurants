<?php

namespace common\models\location;

use Yii;

/**
 * This is the model class for table "location_cities".
 *
 * @property int $id_cities
 * @property int $id_region ID региона
 * @property string $name Название города
 *
 * @property LocationRegions $region
 * @property UserData[] $userDatas
 */
class LocationCities extends \yii\db\ActiveRecord
{
    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['name'];
        $scenarios[self::SCENARIO_CREATE] = ['id_region', 'name'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%location_cities}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_region', 'name'], 'required'],
            [['id_region'], 'default', 'value' => null],
            [['id_region'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => LocationRegions::className(), 'targetAttribute' => ['id_region' => 'id_region']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cities' => 'Id Cities',
            'id_region' => 'Id Region',
            'name' => 'Name',
        ];
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
    public function getUserDatas()
    {
        return $this->hasMany(UserData::className(), ['id_city' => 'id_cities']);
    }
}
