<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee_position}}`.
 */
class m240710_074149_create_employee_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee_position', [
            'id' => $this->primaryKey(),
            'position_name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->batchInsert('employee_position', ['position_name'], [
            ['Nhân Viên'],
            ['HR'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-hr-employee_id', 'employee_position');
        $this->dropTable('employee_position');
    }
}
