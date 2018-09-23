<?php

use yii\db\Migration;

/**
 * Handles adding position to table `project`.
 */
class m180920_202939_add_position_column_to_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'active', $this->boolean() ->
        after('description') -> defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'active');

    }
}
