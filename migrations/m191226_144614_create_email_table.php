<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%email}}`.
 */
class m191226_144614_create_email_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%email}}', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string(255)->notNull(),
            'content'    => $this->text()->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%email}}');
    }
}
