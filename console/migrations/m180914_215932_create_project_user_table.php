<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project_user`.
 */
class m180914_215932_create_project_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user', [
            'project_id' => $this->primaryKey(),
            'user_id' => $this-> integer()->notNull(),
            'role' => "ENUM('manager', 'developer', 'tester')",

        ]);


        //связь с таблицей user
        $this ->addForeignKey(
            'project_user_user',
            'project_user',
            'user_id',
            'user',
            'id'
        );
        //связь с таблицей project
        $this ->addForeignKey(
            'project_user_project',
            'project_user',
            'project_id',
            'project',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_user_user', 'project_user');
        $this->dropForeignKey('project_user_project', 'project_user');
        $this->dropTable('project_user');
    }
}
