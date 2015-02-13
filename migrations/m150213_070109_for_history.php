<?php

use yii\db\Schema;
use yii\db\Migration;

class m150213_070109_for_history extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%moving_history}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'coord_x' => Schema::TYPE_INTEGER . ' NOT NULL',
            'coord_y' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('FK_user_moving', '{{%moving_history}}', 'user_id');
        $this->addForeignKey(
            'FK_user_square', '{{%moving_history}}', 'user_id', '{{%user}}', 'id', 'CASCADE'
        );
    }

    public function down()
    {

        $this->dropTable('{{%moving_history}}');
    }
}
