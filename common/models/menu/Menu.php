<?php

namespace common\models\menu;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name Название категории
 * @property int $id_shop ID магазина
 * @property string $desc Описание
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 * @property int $isToday Меню на сегодня?
 * @property string $img Изображение
 * @property string $ingredients Изображение
 * @property int $id_cat Категории
 * @property decimal $price Цена
 *
 * @property Composition[] $compositions
 * @property Shops $shop
 */
class Menu extends ActiveRecord
{
    public $imgFile;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
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
        if(parent::beforeSave($insert)) {
            if(empty($this->img)) $this->img = 'no-image.png';
            return true;
        }
        return false;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'id_shop', 'img', 'id_cat', 'price', 'desc'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'id_shop', 'id_cat', 'price', 'desc'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_shop', 'img', 'id_cat', 'price'], 'required', 'on' => self::SCENARIO_CREATE],
            [['name', 'id_shop', 'id_cat', 'price', 'ingredients'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['desc', 'ingredients'], 'safe'],
            [['name'], 'string', 'max' => 255],
            ['desc', 'string', 'max' => 1024],
            [['id_shop', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['id_shop', 'created_at', 'updated_at', 'isToday'], 'integer'],
            [['id_shop'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
        ];
    }

    public function upload()
    {
        $path = Yii::getAlias('@frontend') .'/web/uploads/';
        if ($this->validate()) {
            $this->imgFile->saveAs($path . $this->imgFile->baseName . '.' . $this->imgFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'name'          => 'Название',
            'id_shop'       => 'Магазин',
            'desc'          => 'Описание',
            'created_at'    => 'Дата добавления',
            'updated_at'    => 'Дата изменения',
            'isToday'       => 'Меню на сегодня',
            'img'           => 'Изображение',
            'price'         => 'Цена',
            'id_cat'        => 'Категория',
            'ingredients'   => 'Ингредиенты',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompositions()
    {
        return $this->hasMany(Composition::className(), ['id_menu' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop']);
    }

    public function getUserShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop'])
            ->where([Shops::tableName() . '.id_manager' => Yii::$app->user->identity->getId()]);
    }

    public function getShopId()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop']);
    }

    public function getStatistic()
    {
        return $this->hasOne(StatisticMenu::className(), ['id_menu' => 'id']);
    }

}
