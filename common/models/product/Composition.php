<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "composition".
 *
 * @property int $id
 * @property string $key Название состава
 * @property string $value Свойство состава
 * @property int $id_menu ID меню
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 *
 * @property Menu $menu
 */
class Composition extends \yii\db\ActiveRecord
{
    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['key', 'value'];
        $scenarios[self::SCENARIO_CREATE] = ['key', 'value', 'id_menu'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%composition}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'value', 'id_menu'], 'required'],
            [['id_menu', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['id_menu', 'created_at', 'updated_at'], 'integer'],
            [['key', 'value'], 'string', 'max' => 255],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'id_menu' => 'Id Menu',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'id_menu']);
    }
}
