<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $coord_x
 * @property integer $coord_y

 */

class Square extends ActiveRecord
{
    public function __construct()
    {
        $this->user_id = Yii::$app->user->id;
        $this->coord_x = 0;
        $this->coord_y = 0;
    }
    public function relations()
    {
        //return array(
         //   'user_id'=>array(self::BELONGS_TO, 'user', 'id'));
    }

    public function getOwnSquare($currentUser)
    {
        return $this->findByIdentity($currentUser->id);
    }

    public static function getAllSquares()
    {
        return Square::findBySql('SELECT * FROM square')->all();
    }

    public static function getAllSquaresToString()
    {
        return Square::findBySql('SELECT * FROM square')->asArray()->all();
    }

    public static function findByIdentity($id)
    {
        return static::findOne(['user_id' => $id]);
    }
    public function changeOwnSquare()
    {
        $this->coord_x = $_POST['X'];
        $this->coord_y = $_POST['Y'];
        return $this;
    }
    public static function createDefaultSquare()
    {
        $newSquare = new Square();
        $newSquare->user_id = Yii::$app->user->id;
        $newSquare->coord_x = 0;
        $newSquare->coord_y = 0;
        return $newSquare;
    }

}