<?php

declare(strict_types=1);

namespace common\tests;

use Yii;
use yii\console\controllers\MigrateController;

/**
 * Trait Migratable
 * @package common\tests
 */
trait Migratable
{
    /**
     * @var boolean indicates if database migrations have been applied.
     */
    protected static $_isDbMigrationApplied = false;

    /**
     * Apply db migrations to the current database.
     * This method allows to keep test database up to date.
     */
    public static function applyDbMigrations()
    {
    }

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        if (!static::$_isDbMigrationApplied) {
            static::applyDbMigrations();
            static::$_isDbMigrationApplied = true;
        }
    }
}