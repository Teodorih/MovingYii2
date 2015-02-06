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

    public function getOwnSquare($currentUser)
    {
        return $this->findByIdentity($currentUser->id);
    }

    public static function getAllSquares()
    {
        return Square::findBySql('SELECT * FROM square')->all();
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
    public function SaveSquareInDB()
    {
        if(Yii::$app->request->isPost) {
            Yii::$app->db->createCommand()->update('square', ['coord_x' => $this->coord_x, 'coord_y' => $this->coord_y], 'user_id =' . $this->user_id)->execute();
        }
    }

}