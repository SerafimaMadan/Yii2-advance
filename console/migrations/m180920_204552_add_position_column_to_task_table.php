<?php

use yii\db\Migration;

/**
 * Handles adding position to table `task`.
 */
class m180920_204552_add_position_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'project_id',
            $this->integer() -> notNull() -> after('estimation') );


        //связь с таблицей project
        $this ->addForeignKey(
            'task_project',
            'task',
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
        $this->dropForeignKey('task_project', 'task');
        $this->dropColumn('task', 'project_id');

    }
}
