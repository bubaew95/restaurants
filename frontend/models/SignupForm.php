<?php
namespace frontend\models;

use common\models\AddressDelivery;
use common\models\UserData;
use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $id_country;
    public $id_region;
    public $id_city;
    public $address;
    public $password;
    public $repassword;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'fio', 'phone', 'address'], 'trim'],
            [['email', 'fio', 'phone', 'address', 'id_country', 'id_region', 'id_city', 'repassword', 'password'], 'required'],
            [['fio', 'address'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой E-mail уже существует!'],

            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 36],
            ['repassword', 'ischeck'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fio'           => 'Ф.И.О',
            'email'         => 'E-mail',
            'phone'         => 'Телефон',
            'id_city'       => 'Город',
            'address'       => 'Адрес',
            'password'      => 'Пароль',
            'id_region'     => 'Регион',
            'id_country'    => 'Страна',
            'repassword'    => 'Подвтердить пароль',
        ];
    }

    public function ischeck($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->password != $this->repassword) {
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        if($user->save()) {
            $userData = new UserData();
            $userData->fio = $this->fio;
            $userData->phone = $this->phone;
            $userData->id_user = $user->id;
            $userData->save();

            $address = new AddressDelivery();
            $address->id_country = $this->id_country;
            $address->id_region = $this->id_region;
            $address->id_city = $this->id_city;
            $address->address = $this->address;
            $address->id_user = $user->id;
            if( $address->save() ) {
                $this->sendMail($user);
                return [
                    'isAuth' => true,
                    'msg' => 'На ваш email отправлено письмо со ссылкой активации'
                ];
            }
            return $this->regError($user->id);
        }
    }

    private function regError($id)
    {
        Yii::$app->response->setStatusCode(404);
        User::findOne($id)->delete();
        UserData::findOne(['id_user' => $id])->delete();
        AddressDelivery::findOne(['id_user' => $id])->delete();
        return [
            'isAuth' => false,
            'msg' => "Не удалось зарегистрироваться"
        ];
    }

    private function sendMail(User $user)
    {
        return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Password reset for ' . Yii::$app->name)
                ->send();
    }
}
