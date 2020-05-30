<?php

declare(strict_types=1);

use backend\services\ApplesService;

/**
 * Class ApplesServiceTest
 * @coversDefaultClass backend\services\ApplesService
 */
class ApplesServiceTest extends \Codeception\Test\Unit
{
    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testAppleIsFallenAfterHit(): void
    {
        $service = new ApplesService();
        $apple   = $this->getApple(false);

        $service->hit($apple);
        $this->assertTrue($apple->isFallen());
    }

    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testCantHitFallenApples(): void
    {
        $service = new ApplesService();
        $apple   = $this->getApple(true);

        $this->expectException(\common\exceptions\InvalidAppleActionException::class);
        $service->hit($apple);
    }

    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testCantBiteAppleOnTree(): void
    {
        $service = new ApplesService();
        $apple   = $this->getApple(false);

        $this->expectException(\common\exceptions\InvalidAppleActionException::class);
        $this->expectExceptionMessage("Don't eat apples on tree");
        $service->bite($apple, 50);
        $this->assertEquals(100, $apple->integrity);
    }

    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testCantBiteTooMuch(): void
    {
        $service = new ApplesService();
        $apple   = $this->getApple(true);

        $this->expectException(\common\exceptions\InvalidAppleActionException::class);
        $this->expectExceptionMessage("You can't bite so much from this apple");
        $service->bite($apple, 120);
        $this->assertEquals(100, $apple->integrity);
    }

    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testCantBiteSpoiledApple(): void
    {
        $service           = new ApplesService();
        $apple             = $this->getApple(true);
        $apple->spoiled_at = Yii::$app->formatter->asDatetime(strtotime("-1 hours"));

        $this->expectException(\common\exceptions\InvalidAppleActionException::class);
        $this->expectExceptionMessage("Don't eat spoiled apples");
        $service->bite($apple, 30);
        $this->assertEquals(100, $apple->integrity);
    }

    /**
     * @return void
     * @covers ::hit()
     * @throws Exception
     */
    public function testCanBiteGoodApple(): void
    {
        $service = new ApplesService();
        $apple   = $this->getApple(true);

        $service->bite($apple, 30);
        $this->assertEquals(70, $apple->integrity);
    }

    /**
     * @param bool $isFallen
     * @return \common\models\Apple
     * @throws Exception
     */
    protected function getApple(bool $isFallen = false): \common\models\Apple
    {
        $apple = new \common\models\Apple([
            'color'     => \common\models\Apple::COLOR_RED,
            'integrity' => 100,
        ]);

        if ($isFallen) {
            $apple->fallen_at = Yii::$app->formatter->asDatetime(new DateTime());
        }

        $apple->save();

        return $apple;
    }
}