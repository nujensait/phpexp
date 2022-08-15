<?php

// Create user

use yii\db\Migration;

/**
 * Class m220811_095554_create_user
 */
class m220811_095554_create_user extends Migration
{
    // @codingStandardsIgnoreEnd

    /**
     * Table name
     *
     * @var string
     */
    private $_user = "{{%user}}";

    /**
     * @var string
     */
    private $_profile = "{{%profile}}";

    /**
     * Runs for the migate/up command
     *
     * @return null
     */
    public function safeUp()
    {
        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('kbZvdHuUwF');
        $auth_key = Yii::$app->security->generateRandomString();
        $table = $this->_user;

        $sql = <<<SQL
        INSERT INTO {$table}
        (`username`, `email`,`password_hash`, `auth_key`, `created_at`, `updated_at`)
        VALUES
        ('admin', 'admin@zovdemo.com',  '$password_hash', '$auth_key', {$time}, {$time})
SQL;
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * Runs for the migate/down command
     *
     * @return null
     */
    public function safeDown()
    {
        $table = $this->_user;
        $sql = <<<SQL
        SELECT id from {$table}
        where username='admin'
SQL;
        $id = Yii::$app->db->createCommand($sql)->execute();
        $this->delete($this->_user, ['username' => 'admin']);
    }

}