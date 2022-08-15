<?php

use yii\db\Migration;

/**
 * Class m220811_142846_create_tasks
 */
class m220811_142846_create_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('tasks', [
            'name' => 'Task #1',
            'descr' => 'Descr for task #1',
            'priority' => 5,
            'status' => 2,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('tasks', [
            'name' => 'Task #2',
            'descr' => 'Descr for task #2',
            'priority' => 7,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('tasks', [
            'name' => 'Task #3',
            'descr' => 'Descr for task #3',
            'priority' => 7,
            'status' => 0,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('tasks', ['name' => ['Task #1', 'Task #2', 'Task #3']]);
    }
}
