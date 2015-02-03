<?php
namespace app\models;

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

            <div id="dragable" style="
                    top: <?php echo $ownSquare->coord_x ?>px;
                    left:<?php echo $ownSquare->coord_y ?>px;">
            </div>
        </div>
    </div>
<?php
    }
?>