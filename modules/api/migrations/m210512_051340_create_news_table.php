<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210512_051340_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'auth_id' => $this->integer(),
            'date' => $this->datetime(),
            'status' => $this->tinyInteger()->defaultValue(1),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `auth_id`
        $this->createIndex(
            '{{%idx-news-auth_id}}',
            '{{%news}}',
            'auth_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-news-auth_id}}',
            '{{%news}}',
            'auth_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-news-auth_id}}',
            '{{%news}}'
        );

        // drops index for column `auth_id`
        $this->dropIndex(
            '{{%idx-news-auth_id}}',
            '{{%news}}'
        );

        $this->dropTable('{{%news}}');
    }
}
