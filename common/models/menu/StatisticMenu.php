<?php

namespace common\models\menu;

use Yii;

/**
 * This is the model class for table "borz_statistic_menu".
 *
 * @property int $id
 * @property int $id_menu ID Блюда
 * @property double $raiting Рейтинг
 * @property int $count_comm кол-во отзывов
 * @property int $count_order кол-во заказов
 *
 * @property Menu $menu
 */
class StatisticMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%statistic_menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_menu'], 'required'],
            [['id_menu', 'count_comm', 'count_order'], 'default', 'value' => null],
            [['id_menu', 'count_comm', 'count_order'], 'integer'],
            [['raiting'], 'number'],
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
            'id_menu' => 'Id Menu',
            'raiting' => 'Raiting',
            'count_comm' => 'Count Comm',
            'count_order' => 'Count Order',
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
