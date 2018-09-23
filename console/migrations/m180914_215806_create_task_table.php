<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m180914_215806_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this-> string(255)->notNull(),
            'description' => $this-> text()->notNull(),
            'estimation' => $this-> integer()->notNull(),
            'executor_id' => $this-> integer()->null(),
            'started_at' => $this-> integer()->null(),
            'completed_at' => $this-> integer()->null(),
            'created_by' => $this-> integer()->notNull(),
            'updated_by' => $this-> integer()->null(),
            'created_at' => $this-> integer()->notNull(),
            'updated_at' => $this-> integer()->null(),

        ]);
        //связь с таблицей user
        $this ->addForeignKey(
        'task_user',
        'task',
        'executor_id',
        'user',
        'id'
    );
        $this ->addForeignKey(
        'task_user_2',
        'task',
        'created_by',
        'user',
        'id'
    );
        $this ->addForeignKey(
            'task_user_3',
            'task',
            'updated_by',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_user', 'task');
        $this->dropForeignKey('task_user_2', 'task');
        $this->dropForeignKey('task_user_3', 'task');
        $this->dropTable('task');
    }
}
