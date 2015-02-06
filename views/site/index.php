<?php
namespace app\models;
/** @var array $arraySquares */
/** @var array $ownSquare */
use app\models\Square;
use yii\base\Model;
use Yii;

$this->title = 'My Yii Application';
?>
<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <div id="site-index">
        <div id="sq">

            <?php
            foreach($arraySquares as $square)
            {
                if($square->user_id == Yii::$app->user->id)
                {}
                else
                {
                    ?>
                    <div id="<?php echo "square" . $square->user_id ?>" style="position:inherit;
                                                                        top: <?php echo $square->coord_x ?>px  ;
                                                                        left: <?php echo $square->coord_y ?>px;
                                                                        background-color:black;
                                                                        width:50px;
                                                                        height:50px;">
                    </div>
                    <?php
                }
            }
            ?>
            <div id="dragable" style="  top: <?php echo $ownSquare->coord_x ?>px;
                left:<?php echo $ownSquare->coord_y ?>px;">
            </div>

        </div>
    </div>
<?php
    }
?>