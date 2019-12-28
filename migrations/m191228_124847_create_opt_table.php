<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%opt}}`.
 */
class m191228_124847_create_opt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%options}}', [
            'id'       => $this->primaryKey(),
            'title_id' => $this->integer(11),
            'value'    => $this->string(255)->notNull(),
        ]);

        $this->createTable('{{%option_title}}', [
            'id'    => $this->primaryKey(11),
            'group' => $this->integer(11)->notNull()->defaultValue(-1),
            'name'  => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey('fk_opts_opt_title', '{{%options}}', 'title_id', '{{%option_title}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // remove foreign key
        $this->dropForeignKey('fk_opts_opt_title', '{{%options}}');
        // remove tables
        $this->dropTable('{{%options}}');
        $this->dropTable('{{%option_title}}');
    }
}
