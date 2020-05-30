<?php

declare(strict_types=1);

namespace common\helpers;

use common\models\Apple;

/**
 * Class ApplesFactory
 */
class ApplesFactory
{
    /**
     * @return Apple
     * @throws \Exception
     */
    public function random(): Apple
    {
        $colors = [
            Apple::COLOR_YELLOW,
            Apple::COLOR_RED,
            Apple::COLOR_GREEN,
        ];

        $apple = new Apple([
            'color'     => $colors[rand(0, 2)],
            'integrity' => 100,
        ]);

        return $apple;
    }
}