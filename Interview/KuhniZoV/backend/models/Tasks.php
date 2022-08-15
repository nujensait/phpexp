<?php

namespace backend\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string|null $descr
 * @property int $status
 * @property int $priority
 * @property int $created_at
 * @property int $updated_at
 */
class Tasks extends \yii\db\ActiveRecord
{
    private static $statuses = [
        0 => 'создана',
        1 => 'в работе',
        2 => 'выполнена'
    ];

    private static $priorities = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
    ];

    /**
     * @return string[]
     */
    public static function getStatuses()
    {
        return self::$statuses;
    }

    /**
     * @return string[]
     */
    public static function getPriorities()
    {
        return self::$priorities;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['descr'], 'string'],
            [['status', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД'),
            'name' => Yii::t('app', 'Название'),
            'descr' => Yii::t('app', 'Описание'),
            'status' => Yii::t('app', 'Статус'),
            'priority' => Yii::t('app', 'Приоритет'),
            'created_at' => Yii::t('app', 'Создана'),
            'updated_at' => Yii::t('app', 'Обновлена'),
        ];
    }

    /**
     * @return array[]
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => time() //new Expression('NOW()'),
            ],
        ];
    }
}
