<?php

namespace common\models\category;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name Название категории
 * @property string $tr_name Анг.название категории
 *
 * @property Products[] $products
 */
class Categories extends \yii\db\ActiveRecord
{

    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['name'];
        $scenarios[self::SCENARIO_CREATE] = ['name', 'tr_name'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['tr_name'], 'safe'],
            [['tr_name'], 'validateAlias'],
            [['name', 'tr_name'], 'string', 'max' => 255],
        ];
    }

    public function validateAlias($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!preg_match('/^[a-z0-9_-]+$/i', $this->tr_name)) {
                $this->addError($attribute, 'Ввод кириллицы запрешено');
            }
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(empty($this->tr_name))
                $this->tr_name = createAlias($this->name);
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => 'Название',
            'tr_name'   => 'Алиас',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id_cat' => 'id']);
    }
}
