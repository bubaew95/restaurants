<?php

namespace common\models\pages;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "borz_pages".
 *
 * @property int $id
 * @property string $name Название страницы
 * @property string $tr_name Название на латинице
 * @property string $text Текст
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 */
class Pages extends ActiveRecord
{
    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['name', 'text'];
        $scenarios[self::SCENARIO_CREATE] = ['name', 'text', 'tr_name'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'tr_name'], 'string', 'max' => 255],
            ['text','filter', 'filter' => function ($value) {
                return \yii\helpers\HtmlPurifier::process($value);
            }]
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(empty($this->tr_name))
                $this->tr_name = createAlias($this->name);
            $this->text = HtmlPurifier::process($this->text);
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
            'id' => 'ID',
            'name' => 'Название ',
            'tr_name' => 'Алиас',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }
}
