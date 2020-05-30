<?php

use yii\db\Migration;

/**
 * Class m200530_092918_apples
 */
class m200530_092918_apples extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apple', [
            'id'         => $this->primaryKey(),
            'color'      => $this->string()
                ->notNull()
                ->comment('Цвет'),
            'integrity'  => $this->tinyInteger()
                ->unsigned()
                ->notNull()
                ->comment('Целостность'),
            'fallen_at'  => $this->timestamp()
                ->null()
                ->comment('Время падения'),
            'spoiled_at' => $this->timestamp()
                ->null()
                ->comment('Время когда испортится'),
            'created_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->comment('Время создания'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apple');
    }
}
