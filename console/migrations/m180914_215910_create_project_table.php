<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180914_215910_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this-> string(255)->notNull(),
            'description' => $this-> text()->notNull(),
            'created_by' => $this-> integer()->notNull(),
            'updated_by' => $this-> integer()->null(),
            'created_at' => $this-> integer()->notNull(),
            'updated_at' => $this-> integer()->null(),
        ]);
        //связь с таблицей user
        $this ->addForeignKey(
            'project_user',
            'project',
            'created_by',
            'user',
            'id'
        );
        //связь с таблицей user
        $this ->addForeignKey(
            'project_user_2',
            'project',
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
        $this->dropForeignKey('project_user', 'project');
        $this->dropForeignKey('project_user_2', 'project');
        $this->dropTable('project');
    }
}
