<?php

declare(strict_types=1);

namespace common\exceptions;

use common\models\Apple;

/**
 * Class InvalidAppleActionException
 */
class InvalidAppleActionException extends \ErrorException
{
    /**
     * @var Apple
     */
    private $apple;

    /**
     * @param Apple $apple
     * @return InvalidAppleActionException
     */
    public function setApple(Apple $apple): InvalidAppleActionException
    {
        $this->apple = $apple;
        return $this;
    }

    /**
     * @return Apple
     */
    public function getApple(): Apple
    {
        return $this->apple;
    }
}