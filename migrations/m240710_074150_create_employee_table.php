<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees}}`.
 */
class m240710_074150_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string(),
            'password' => $this->string(),
            'position_id' => $this->integer(),
            'access_token' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-employee-position_id',
            'employee',
            'position_id',
            'employee_position',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-employee-position_id', 'employee');
        $this->dropTable('{{%employee}}');
    }
}
