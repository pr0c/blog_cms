<?php

use yii\db\Migration;

class m160307_222405_first_start extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName == 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'token' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'rights' => $this->integer()->notNull(),
            'regDate' => $this->string()->notNull(),
            'posts' => $this->integer()->notNull()
        ], $tableOptions);
        $this->createIndex('username', "{{%users}}", 'username', true);

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull()
        ], $tableOptions);
        $this->createIndex('name', '{{%category}}', 'name', true);

        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'category_id' => $this->smallInteger()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'url' => $this->string()->notNull(),
            'date_creation' => $this->dateTime()->notNull(),
            'comments_count' => $this->integer()->notNull()
        ], $tableOptions);
        $this->createIndex('author_id', '{{%posts}}', 'author_id');

        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'date_creation' => $this->dateTime()->notNull(),
            'post_id' => $this->integer()->notNull()
        ], $tableOptions);
        $this->createIndex('post_id', '{{%comments}}', 'post_id');

        $this->execute($this->addUserSql());
    }

    private function addUserSql()
    {
        $password = Yii::$app->security->generatePasswordHash(Yii::$app->params['adminPass']);
        $auth_key = Yii::$app->security->generateRandomString();
        $token = Yii::$app->security->generateRandomString() . '_' . time();
        $login = Yii::$app->params['adminLogin'];
        $email = Yii::$app->params['adminEmail'];
        $rights = Yii::$app->params['adminRight'];
        $date = date('d.m.Y');
        return "INSERT INTO {{%users}} (`username`, `password`, `auth_key`, `token`, `email`, `rights`, `regDate`, `posts`) VALUES ('$login', '$password', '$auth_key', '$token', '$email', '$rights', '$date', 0)";
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%posts}}');
        $this->dropTable('{{%comments}}');
    }
}
