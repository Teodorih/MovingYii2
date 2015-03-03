<?php

use yii\db\Schema;
use yii\db\Migration;

class m150303_095108_addDefault extends Migration
{
    public function up()
    {
        $this->alterColumn("square","user_id","int not null default 0");
        $this->alterColumn("square","coord_x","int not null default 0");
        $this->alterColumn("square","coord_y","int not null default 0");
    }

    public function down()
    {
        echo "m150303_095108_addDefault cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
