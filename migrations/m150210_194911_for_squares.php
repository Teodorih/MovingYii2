<?php

use yii\db\Schema;
use yii\db\Migration;

class m150210_194911_for_squares extends Migration
{
    public function up()
    {
      $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
 
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP,
            'updated_at' => Schema::TYPE_TIMESTAMP,
        ], $tableOptions);
 
        $this->createTable('{{%square}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'coord_x' => Schema::TYPE_INTEGER . ' NOT NULL',
            'coord_y' => Schema::TYPE_INTEGER . ' NOT NULL',            
        ], $tableOptions);
 
        $this->createIndex('FK_user_square', '{{%square}}', 'user_id');
        $this->addForeignKey(
            'FK_user_square', '{{%square}}', 'user_id', '{{%user}}', 'id', 'CASCADE'
        ); 
        
    }

    public function down()
    {
       $this->dropTable('{{%user}}');
        $this->dropTable('{{%square}}');
    }
}
