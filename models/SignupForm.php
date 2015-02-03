<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;
/**
 * Created by PhpStorm.
 * User: teo
 * Date: 30.01.15
 * Time: 22:03
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}