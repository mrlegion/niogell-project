<?php

use yii\db\Migration;

/**
 * Class m191204_092028_base_created_tabels
 */
class m191204_092028_base_created_tabels extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // create user table
        // use this table for admin or other control person
        $this->createTable('{{%user}}', [
            'id'           => $this->primaryKey(11),
            'email'        => $this->string(255)->notNull(),
            'username'     => $this->string(255)->notNull(),
            'first_name'   => $this->string(255)->notNull(),
            'last_name'    => $this->string(255)->notNull(),
            'password'     => $this->string(255)->notNull(),
            'access_token' => $this->string(255)->notNull(),
            'auth_key'     => $this->string(255)->notNull(),
            'verify_token' => $this->string(255)->null()->defaultValue(null),
            'is_blocked'   => $this->smallInteger(1)->defaultValue(0)->notNull(),
            'created_at'   => $this->date(),
            'updated_at'   => $this->date(),
        ]);

        // create votes table
        $this->createTable('{{%vote}}', [
            'id'           => $this->primaryKey(11),
            'email'        => $this->string(255)->notNull(),
            'phone'        => $this->string(20)->notNull(),
            'age'          => $this->smallInteger(2)->notNull(),
            'state'        => $this->string(255)->notNull(),
            'city'         => $this->string(255)->notNull(),
            'street'       => $this->string(255)->notNull(),
            'home'         => $this->string(255)->notNull(),
            'rating'       => $this->smallInteger(2)->notNull(),
            'text'         => $this->text(),
            'verify_token' => $this->string(255)->notNull(),
            'status'       => $this->smallInteger(2)->defaultValue(0)->notNull(),
            'created_at'   => $this->date(),
            'updated_at'   => $this->date(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}');
        $this->delete('{{%vote}}');

        echo "m191204_092028_base_created_tables has be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_092028_base_created_tabels cannot be reverted.\n";

        return false;
    }
    */
}
