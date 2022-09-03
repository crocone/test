<?php

class m220903_152621_create_code_table extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('{{%code}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'created_at' => 'datetime DEFAULT NOW()',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%code}}');
    }
}