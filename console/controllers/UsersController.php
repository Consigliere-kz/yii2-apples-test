<?php

declare(strict_types=1);

namespace console\controllers;

use common\models\User;
use Seld\CliPrompt\CliPrompt;
use yii\helpers\Console;

/**
 * Class UsersController
 */
class UsersController extends \yii\console\Controller
{
    /**
     * @param $username
     * @return int
     * @throws \Exception
     */
    public function actionAdd($username): int
    {
        if (User::findByUsername($username)) {
            $this->stdout("User with name `{$username}` already exists.\n", Console::FG_RED);

            return 1;
        }

        $password = null;

        while (!$password) {
            $this->stdout('Type password: ');
            $password = CliPrompt::hiddenPrompt();
        }

        $this->stdout('Confirm password: ');
        $repeat = CliPrompt::hiddenPrompt();

        if ($repeat !== $password) {
            $this->stdout("Invalid password\n", Console::FG_RED);

            return 1;
        }

        $user = new User([
            'username' => $username,
            'auth_key' => bin2hex(random_bytes(8)),
            'email' => "$username@test.te",
            'status' => User::STATUS_ACTIVE,
        ]);
        $user->password = $password;

        if (!$user->save()) {
            $this->stdout("Can't save user");
            $this->stdout(json_encode($user->getFirstErrors()));
        }

        $this->stdout("User `{$username}` created successfully\n");

        return 0;
    }
}