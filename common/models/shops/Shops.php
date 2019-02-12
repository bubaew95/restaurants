<?php

namespace common\models\shops;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "borz_shops".
 *
 * @property int $id
 * @property int $id_manager ID менеджера
 * @property string $name Название
 * @property string $tr_name Анг.название
 * @property string $logo Логотип
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 * @property int $published Статус публикации
 * @property string $description Описание магазина
 * @property int $id_country Страна
 * @property int $id_region Регион
 * @property int $id_city Город
 * @property string $address Адрес
 * @property int $index Индекс
 * @property string $phone Телефон
 * @property string $email Еmail
 *
 * @property Cart[] $cards
 * @property Menu[] $menus
 * @property Orders[] $orders
 * @property Products[] $products
 * @property LocationCities $city
 * @property LocationCountries $country
 * @property LocationRegions $region
 * @property User $manager
 */
class Shops extends ActiveRecord
{

    const PUBLISHED = 1;
    const UNPUBLISHED = 0;
    public $img_logo;

    const SCENARIO_DEFAULT =  'default';
    const SCENARIO_CREATE =  'create';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['name', 'phone', 'email', 'description', 'index'];
        $scenarios[self::SCENARIO_CREATE] = ['name', 'phone', 'email', 'id_country', 'id_region', 'id_city', 'description', 'index'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shops}}';
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
            if(empty($this->tr_name))
                $this->tr_name = createAlias($this->name);
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'id_country', 'id_region', 'id_city', 'description', 'index'], 'required'],
            [['id_manager', 'created_at', 'updated_at', 'published', 'id_country', 'id_region', 'id_city', 'index'], 'default', 'value' => null],
            [['id_manager', 'created_at', 'updated_at', 'published', 'id_country', 'id_region', 'id_city', 'index'], 'integer'],
            [['description'], 'string'],
            [['id_manager', 'img_logo', 'tr_name'], 'safe'],
            [['name', 'tr_name', 'logo', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => LocationCities::className(), 'targetAttribute' => ['id_city' => 'id_cities']],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => LocationCountries::className(), 'targetAttribute' => ['id_country' => 'id_country']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => LocationRegions::className(), 'targetAttribute' => ['id_region' => 'id_region']],
            [['id_manager'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_manager' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'id_manager'    => 'Менеджер',
            'name'          => 'Название',
            'tr_name'       => 'Алиас',
            'logo'          => 'Логотип',
            'created_at'    => 'Дата добавления',
            'updated_at'    => 'Дата изменения',
            'published'     => 'Статус видимости',
            'description'   => 'Описание',
            'id_country'    => 'Страна',
            'id_region'     => 'Регион',
            'id_city'       => 'Город',
            'address'       => 'Адрес',
            'index'         => 'Почтовый индекс',
            'phone'         => 'Телефон',
            'email'         => 'E-mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Cart::className(), ['id_shop' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id_shop' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['id_shop' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id_shop' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(LocationCities::className(), ['id_cities' => 'id_city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(LocationCountries::className(), ['id_country' => 'id_country']);
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
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'id_manager']);
    }
}
