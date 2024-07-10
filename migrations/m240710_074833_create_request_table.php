<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m240710_074833_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'leave_date' => $this->date(),
            'leave_reason' => $this->text(),
            'request_status_id' => $this->integer()->defaultValue(1), // Default to Pending
            'hr_id' => $this->integer()->null(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-request-employee_id',
            'request',
            'employee_id',
            'employee',
            'id',
            'CASCADE'
        );

        // Foreign key for status_id
        $this->addForeignKey(
            'fk-request-request_status_id',
            'request',
            'request_status_id',
            'request_status',
            'id',
            'CASCADE'
        );

        // Foreign key for hr_manager_id
//        $this->addForeignKey(
//            'fk-request-hr_manager_id',
//            'request',
//            'hr_id',
//            'hr',
//            'id',
//            'SET NULL'
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-requests-employee_id', 'request');
        $this->dropForeignKey('fk-requests-request_status_id', 'request');
//        $this->dropForeignKey('fk-requests-hr_id', 'request');
        $this->dropTable('{{%request}}');
    }
}
