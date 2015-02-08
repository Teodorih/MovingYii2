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
    public static function LoadNewOwnSquare()
    {
        $newOwnSquare = new Square();
        $newOwnSquare->user_id = $_POST['ip'];
        $newOwnSquare->coord_x = $_POST['X'];
        $newOwnSquare->coord_y = $_POST['Y'];
        return $newOwnSquare;
    }
    public function InsertSquareInDB()
    {
        Yii::$app->db->createCommand()->insert('square',['coord_x' => $this->coord_x, 'coord_y' => $this->coord_y, 'user_id' => $this->user_id])->execute();

    }
    public function UpdateSquareInDB()
    {
        if(Yii::$app->request->isPost) {
            Yii::$app->db->createCommand()->update('square', ['coord_x' => $this->coord_x, 'coord_y' => $this->coord_y], 'user_id =' . $this->user_id)->execute();
        }
    }
    public static function CreateDefaultSquare()
    {
        $newSquare = new Square();
        $newSquare->user_id = Yii::$app->user->id;
        $newSquare->coord_x = 0;
        $newSquare->coord_y = 0;
        return $newSquare;
    }

}