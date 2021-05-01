<?php

use yii\db\Migration;

/**
 * Class m210501_192030_add_created_at_to_column_post_table
 */
class m210501_192030_add_created_at_to_column_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'created_at', $this->integer());
        $this->dropColumn('post', 'update_at');
        $this->addColumn('post', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('post', 'update_at', $this->integer());
        $this->dropColumn('post', 'updated_at');
        $this->dropColumn('post', 'created_at');
    }

}
