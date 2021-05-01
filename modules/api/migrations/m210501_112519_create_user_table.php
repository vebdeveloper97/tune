<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210501_112519_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'         => $this->primaryKey(),
            'username'   => $this->string(50)->notNull()->unique(),
            'password'   => $this->string(255)->notNull(),
            'auth_token' => $this->string(100),
            'date'       => $this->datetime(),
            'status'     => $this->tinyinteger()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-user-username',
            '{{%user}}',
            'username'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-username',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');
    }
}
