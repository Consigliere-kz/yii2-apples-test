<?php

namespace common\models;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color Цвет
 * @property int $integrity Целостность
 * @property string|null $fallen_at Время падения
 * @property string|null $spoiled_at Время когда испортится
 * @property-read string $created_at Время создания
 */
class Apple extends \yii\db\ActiveRecord
{
    const COLOR_GREEN  = 'green';
    const COLOR_RED    = 'red';
    const COLOR_YELLOW = 'yellow';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'in', 'range' => [static::COLOR_GREEN, static::COLOR_RED, static::COLOR_YELLOW,]],
            [['color', 'integrity'], 'required'],
            [['integrity'], 'integer', 'min' => 0, 'max' => 100],
            [['fallen_at', 'spoiled_at'], 'datetime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'color'      => 'Color',
            'integrity'  => 'Integrity',
            'fallen_at'  => 'Fallen At',
            'spoiled_at' => 'Spoiled At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return bool
     */
    public function isFallen(): bool
    {
        return $this->fallen_at !== null;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isSpoiled(): bool
    {
        return $this->spoiled_at && $this->spoiled_at <= new \DateTime();
    }

    /**
     * @param int $id
     * @return static|null
     */
    public function findOneForUpdate(int $id): ?Apple
    {
        $sql = self::find()
            ->where(['id' => $id])
            ->createCommand()
            ->getRawSql();

        return self::findBySql($sql . ' FOR UPDATE')->one();
    }
}
