<?php

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property integer $created_at
 * @property integer $updated_at

 */

class User extends ActiveRecord implements IdentityInterface
{



    /**
     * @inheritdoc
     */
    public  function getSquares()
    {
        return $this->hasMany(Square::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public static function getAllFromUsersAndSquares()
    {
        //return User::findBySql('SELECT * FROM user')->joinWith('square')->all();
      // return User::find()->joinWith('square')->all();
        //$orders = Order::find()->innerJoinWith('books')->all();
        $customer = User::findBySql('SELECT * FROM user')->all();
        $orders = $customer->squares;
        return null;


    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->authKey;
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
        return null;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       // return $this->password === $password;
        return null;
    }
}
