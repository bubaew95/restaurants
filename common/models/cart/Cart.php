<?php

namespace common\models\cart;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property string $total_sum Название категории
 * @property int $total_qty ID магазина
 * @property int $id_user ID заказчика
 * @property int $id_manager ID менеджера
 * @property int $id_tranpor ID доставщика
 * @property int $id_status Статус заказа
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 *
 * @property Status $status
 * @property User $user
 * @property User $manager
 * @property User $tranpor
 */
class Cart extends yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_sum', 'total_qty'], 'required'],
            [['total_qty', 'id_user', 'id_manager', 'id_tranpor', 'id_status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['total_qty', 'id_user', 'id_manager', 'id_tranpor', 'id_status', 'created_at', 'updated_at'], 'integer'],
            [['total_sum'], 'string', 'max' => 255],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_shop'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
            [['id_tranpor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_tranpor' => 'id']],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'id_user'       => 'Заказчик',
            'id_status'     => 'Статус заказа',
            'total_sum'     => 'Общая сумма',
            'total_qty'     => 'Кол-во заказа',
            'id_shop'       => 'Ресторан',
            'id_tranpor'    => 'Доставшик',
            'created_at'    => 'Дата заказа',
            'updated_at'    => 'Дата обработки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'id_status']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranpor()
    {
        return $this->hasOne(User::className(), ['id' => 'id_tranpor']);
    }
}
