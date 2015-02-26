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
    public static $query = "SELECT t1.* FROM square t1
  JOIN (SELECT user_id, MAX(id) id FROM square GROUP BY user_id) t2
    ON t1.id = t2.id AND t1.user_id = t2.user_id;";

  /*  public function __construct()
    {
        $this->user_id = Yii::$app->user->id;
        $this->coord_x = 0;
        $this->coord_y = 0;
    }*/
    //public function __construct($config=['user_id'=>, 'coord_x'=>0,'coord_y'=>0])
    //{
        // ... initialization before configuration is applied

        //parent::__construct($config);
    //}
    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public static function getCurrentSquares()
    {
        $query = "SELECT t1.* FROM square t1
  JOIN (SELECT user_id, MAX(id) id FROM square GROUP BY user_id) t2
    ON t1.id = t2.id AND t1.user_id = t2.user_id;";
        return Square::findBySql($query);
    }

    public static function findByIdentity($id)
    {
        return static::findOne(['user_id' => $id]);
    }
    public function addCurrentCoordsToSquare()
    {
        $this->coord_x = $_POST['X'];
        $this->coord_y = $_POST['Y'];
        return $this;
    }
    public function saveInHistoryTable()
    {
        Yii::$app->db->createCommand()->insert('moving_history',[
            'user_id' => $this->user_id,
            'coord_x' => $this->coord_x,
            'coord_y' => $this->coord_y,
    ])->execute();

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