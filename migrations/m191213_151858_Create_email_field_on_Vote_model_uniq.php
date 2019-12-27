<?php

use yii\db\Migration;

/**
 * Class m191213_151858_Create_email_field_on_Vote_model_uniq
 */
class m191213_151858_Create_email_field_on_Vote_model_uniq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('email', '{{%vote}}', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191213_151858_Create_email_field_on_Vote_model_uniq can be reverted.\n";
        $this->dropIndex('email', '{{%vote}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191213_151858_Create_email_field_on_Vote_model_uniq cannot be reverted.\n";

        return false;
    }
    */
}
