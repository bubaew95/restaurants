<?php

namespace common\models\slider;

use Yii;

/**
 * This is the model class for table "borz_slider_img".
 *
 * @property int $id
 * @property string $image путь к изобрежению
 * @property int $id_shop ID ресторана
 *
 * @property Shops $shop
 */
class SliderImg extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider_img}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['image', 'id_shop'];
        $scenarios[self::SCENARIO_UPDATE] = ['id_shop'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'id_shop'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id_shop'], 'required', 'on' => self::SCENARIO_UPDATE],
            ['img', 'safe'],
            [['id_shop'], 'default', 'value' => null],
            [['id_shop'], 'integer'],
            [['image'], 'string', 'max' => 255],
            ['image', 'image', 'minWidth' => 1920, 'minHeight' => 500,  'extensions' => 'jpg, gif, png'],
            [['id_shop'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['id_shop' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'image'     => 'Изображение',
            'id_shop'   => 'Ресторан',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'id_shop']);
    }

}
