<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_status}}`.
 */
class m240710_074805_create_request_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_status}}', [
            'id' => $this->primaryKey(),
            'status_name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->batchInsert('request_status', ['status_name'], [
            ['Pending'],
            ['Approved'],
            ['Rejected']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request_status}}');
    }
}
