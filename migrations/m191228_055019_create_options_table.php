<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%options}}`.
 */
class m191228_055019_create_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%options}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%options}}');
    }
}
