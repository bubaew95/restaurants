<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int $id_cat ID категории
 * @property int $id_manager ID Менеджера
 * @property int $id_shop ID Магазина
 * @property string $price Цена продукта
 * @property int $salePercent Скидка
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 * @property int $published Статус публикации
 *
 * @property Orders[] $orders
 * @property Categories $cat
 * @property Shops $shop
 * @property User $manager
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_cat', 'id_manager', 'id_shop', 'salePercent', 'created_at', 'updated_at', 'published'], 'default', 'value' => null],
            [['id_cat', 'id_manager', 'id_shop', 'salePercent', 'created_at', 'updated_at', 'published'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_shop'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
            [['id_manager'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_manager' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'id_cat' => 'Категория',
            'id_manager' => 'Менеджер',
            'id_shop' => 'Магазин',
            'price' => 'Цена',
            'salePercent' => 'Скидка-',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'published' => 'Статус публикации',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['id_product' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'id_manager']);
    }
}
