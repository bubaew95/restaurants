<?php

namespace common\models\comments;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "borz_comments".
 *
 * @property int $id
 * @property int $id_user ID пользователя
 * @property int $id_menu ID Меню
 * @property string $text Текст отзыва
 * @property double $raiting Рейтинг
 * @property int $created_at Дата добавления
 */
class Comments extends ActiveRecord
{

    const SCENARIO_DEFAULT =  'default';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['id_user', 'id_menu'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_menu', 'created_at'], 'default', 'value' => null],
            [['id_user', 'id_menu', 'created_at'], 'integer'],
            ['id_menu', 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
            ['id_user', 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['text'], 'required'],
            [['text'], 'string'],
            [['raiting'], 'number'],
        ];
    }

    public function behaviors(){
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id user',
            'id_menu' => 'Id Menu',
            'text' => 'Text',
            'raiting' => 'Raiting',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getUserData()
    {
        return $this->hasOne(UserData::className(), ['id_user' => 'id_user'])->select(['fio']);
    }

    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'id_menu']);
    }
}
