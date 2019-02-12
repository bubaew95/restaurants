<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 10.08.2018
 * Time: 11:49
 */

namespace frontend\models;


use common\models\Menu;
use common\models\User;
use yii\base\Model;

class CommentsForm extends Model
{

    public $id_menu;
    public $id_user;
    public $raiting;
    public $text;

    public function rules()
    {
        return [
            [['raiting', 'text'], 'required'],
            [['id_menu', 'id_user'], 'safe'],
            ['id_menu', 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
            ['id_user', 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['raiting'], 'double'],
            ['text', 'string', 'min' => 3],
        ];
    }

    public function attributeLabels()
    {
        return [
            'raiting' => 'Оценка',
            'text' => 'Отзыв',
            'id_menu' => 'Меню',
            'id_user' => 'Пользователь',
        ];
    }

}