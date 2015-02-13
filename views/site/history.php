<?php
namespace app\models;
/** @var array $arrayUsers */
use app\models\Square;
use app\models\User;
use yii\base\Model;
use Yii;
?>
<ul id="navForHistory" class="nav nav-tabs" role="tablist">
  <!--<li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="#">Profile</a></li>
  <li role="presentation"><a href="#">Messages</a></li>-->
  <?php foreach($arrayUsers as $user)
  {
    ?><li role="presentation"><a href="#"><?php echo $user->username?></a></li><?php
  }
  ?>
</ul>
