<?php

declare(strict_types=1);

namespace backend\services;

use common\exceptions\InvalidAppleActionException;
use common\models\Apple;
use Yii;

/**
 * Class ApplesService
 */
class ApplesService
{
    /**
     * @param Apple $apple
     * @throws InvalidAppleActionException
     * @throws \yii\base\InvalidConfigException
     */
    public function hit(Apple $apple): void
    {
        if ($apple->isFallen()) {
            throw (new InvalidAppleActionException("Don't hit fallen apples"))->setApple($apple);
        }

        $fallenTime       = new \DateTime();
        $apple->fallen_at = Yii::$app->formatter->asDatetime($fallenTime);

        $spoilingInterval  = Yii::$app->params['fallenAppleLifetime'] ?: 5 * 3600;
        $apple->spoiled_at = Yii::$app->formatter->asDatetime(
            $fallenTime->add(new \DateInterval("PT{$spoilingInterval}S"))
        );

        $apple->save();
    }

    /**
     * @param Apple $apple
     * @param int $percentage
     * @throws InvalidAppleActionException
     */
    public function bite(Apple $apple, int $percentage): void
    {
        if (!$apple->isFallen()) {
            throw (new InvalidAppleActionException("Don't eat apples on tree"))->setApple($apple);
        }

        if ($apple->isSpoiled()) {
            throw (new InvalidAppleActionException("Don't eat spoiled apples"))->setApple($apple);
        }

        if ($apple->integrity < $percentage) {
            throw (new InvalidAppleActionException("You can't bite so much from this apple"))->setApple($apple);
        }

        $apple->integrity = $apple->integrity - $percentage;
        $apple->save();
    }
}