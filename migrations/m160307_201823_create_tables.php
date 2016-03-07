<?php

use yii\db\Migration;

class m160307_201823_create_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if($this->db->driverName == 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            $this->createTable('{{%users}}', [
                'id' => Schema::TYPE_PK,
                'username' => $this->string()->notNull(),
                'password' => $this->string()->notNull(),
                'auth_key' => $this->string()->notNull(),
                'token' => $this->string()->notNull(),
                'email' => $this->string()->notNull(),
                'rights' => $this->integer()->notNull(),
                'regDate' => $this->dateTime()->notNull(),
            ], $tableOptions);
        }
    }

    public function down()
    {
    
    }

}
