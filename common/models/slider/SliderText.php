<?php

namespace common\models\slider;

use Yii;

/**
 * This is the model class for table "borz_slider_text".
 *
 * @property int $id
 * @property int $id_slider ID слайдера
 * @property string $blob Текст
 * @property int $type Тип строки
 * @property int $data_x data x
 * @property int $data_y data y
 * @property string $data_splitin splitin
 * @property string $data_splitout splitout
 * @property double $data_elementdelay elementdelay
 * @property int $data_start start
 * @property int $data_speed speed
 * @property string $data_easing easing
 * @property string $data_customin customin
 * @property string $data_customout customout
 * @property int $data_endspeed endspeed
 * @property string $data_endeasing endeasing
 * @property string $data_captionhidden captionhidden
 * @property string $style style
 * @property string $classes Стили
 */
class SliderText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider_text}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_slider', 'type', 'data_x', 'data_y', 'data_start', 'data_speed', 'data_endspeed'], 'default', 'value' => null],
            [['id_slider', 'type', 'data_x', 'data_y', 'data_start', 'data_speed', 'data_endspeed'], 'integer'],
            [['blob'], 'required'],
            ['classes', 'safe'],
            [['data_elementdelay'], 'number'],
            [['blob', 'data_customin', 'data_customout', 'data_captionhidden'], 'string', 'max' => 255],
            [['data_splitin', 'data_splitout', 'data_easing', 'data_endeasing'], 'string', 'max' => 20],
            [['style'], 'string', 'max' => 100],
            ['style', 'default', 'value' => 'z-index: 1;'],
            [['data_x','data_y', 'data_elementdelay'], 'default', 'value' => 0],
            ['data_start', 'default', 'value' => 1000],
            ['data_speed', 'default', 'value' => 600],
            ['data_endspeed', 'default', 'value' => 500],
            ['data_customin', 'default', 'value' => 'x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;'],
            ['data_customout', 'default', 'value' => 'x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;'],
        ];
    }

    public function setClasses(array $val = [])
    {
        $this->classes = implode(' ', $val);
    }

    public function getClasses()
    {
        return explode(' ', $this->classes);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'blob'               => 'Blob',
            'type'               => 'Тип',
            'style'              => 'Style',
            'data_y'             => 'Позиция по Y',
            'data_x'             => 'Позиция по X',
            'classes'            => 'Стили',
            'id_slider'          => 'Id Slider',
            'data_start'         => 'Время показа',
            'data_speed'         => 'Скорость показа',
            'data_easing'        => 'Data Easing',
            'data_splitin'       => 'Data Splitin',
            'data_splitout'      => 'Data Splitout',
            'data_customin'      => 'Data Customin',
            'data_endspeed'      => 'Скорость скрытия',
            'data_customout'     => 'Data Customout',
            'data_endeasing'     => 'Data Endeasing',
            'data_elementdelay'  => 'Data Elementdelay',
            'data_captionhidden' => 'Data Captionhidden'

        ];
    }
}
