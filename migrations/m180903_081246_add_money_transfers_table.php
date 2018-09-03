<?php

use yii\db\Migration;

/**
 * Class m180903_081246_add_money_transfers_table
 */
class m180903_081246_add_money_transfers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%money_transfers}}', [
            'id' => $this->primaryKey(),
            'from_user' => $this->integer()->notNull(),
            'to_user' => $this->integer()->notNull(),
            'process_after' => $this->dateTime()->notNull(),
            'is_processed' => $this->boolean()->defaultValue(false),
            'sum' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->addForeignKey(
            'money_transfer_to_user_id_fk',
            '{{%money_transfers}}',
            'to_user',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'money_transfer_from_user_id_fk',
            '{{%money_transfers}}',
            'from_user',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('money_transfer_process_after_indx', '{{%money_transfers}}', 'process_after');
        $this->createIndex('money_transfer_from_user_indx', '{{%money_transfers}}', 'from_user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%money_transfers}}');
    }
}
