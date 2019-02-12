<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "borz_delivery".
 *
 * @property int $id
 * @property string $name Название доставки
 * @property string $description Описание доставки
 * @property string $price Цена доставки
 * @property int $not_csd_pr Не учитывать цену
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%delivery}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price'], 'number'],
            [['not_csd_pr'], 'default', 'value' => null],
            [['not_csd_pr'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'not_csd_pr' => 'Not Csd Pr',
        ];
    }
}
