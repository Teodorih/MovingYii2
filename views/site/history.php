<?php
namespace app\models;
/** @var array $arrayUsers */
use app\models\Square;
use app\models\User;
use yii\base\Model;
use Yii;

?>
<div id="content">


  <ul id="tabs" class="nav nav-tabs" data-tabs="tabs" >
    <?php foreach($arrayUsers as $user)
    {
      ?><li><a href="<?php echo '#'.$user->username?>" data-toggle="tab"><?php echo $user->username?></a></li><?php
    }
    ?>
  </ul>
  <div id="my-tab-content" class="tab-content">
    <?php foreach($arrayUsers as $user) {
    ?>
    <div class="tab-pane" id="<?php echo $user->username ?>">
      <h1><?php echo 'Coordinates for ' . $user->username ?></h1>


      <table class="table">

        <thead>

        <tr>

          <th>Step</th>

          <th>Coordinates X</th>

          <th>Coordinates Y</th>

        </tr>

        </thead>

        <?php
        $AutoincrementIndex =0;
        foreach ($user->square as $square) {
            $AutoincrementIndex++;
            ?>
            <tbody>
  
            <tr>

              <td><?php echo $AutoincrementIndex?></td>

              <td><?php echo $square->coord_x?></td>

              <td><?php echo $square->coord_y?></td>

            </tr>

            </tbody>
          <?php
        }
        ?>

        </table>



      </div>
    <?php
    }
    ?>
  </div>
</div>

<div class="container">

  <!-------->



  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      $('#tabs').tab();
    });
  </script>
</div> <!-- container -->
