<?php

class m220903_152110_seed_data extends \yii\db\Migration
{
    public function up()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'user',
            'email' => 'user@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('user'),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => \app\models\User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    public function down()
    {
        $this->delete('{{%user}}', [
            'id' => [1]
        ]);
    }
}