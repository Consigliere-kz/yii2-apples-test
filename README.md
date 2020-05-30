# Установка
* ```git clone git@github.com:Consigliere-kz/yii2-apples-test.git```
* ```composer install```
* ```./init```
* Настройте подключение к БД: ```nano common/config/main-local.php```
* Настройте веб-сервер на backend часть приложения ([Installation manual](https://www.yiiframework.com/extension/yiisoft/yii2-app-advanced/doc/guide/2.0/en/start-installation#preparing-application))
* ```php yii migrate```
* Добавьте пользователя в приложение: ```php yii users/add username```

# Использование
* Перейдите по адресу, где развернуто приложение (напр-р backend.dev)
* Авторизуйтесь используя логин/пароль созданного пользователя
* Нажмите "Regenerate apples", чтобы сгенерировать набор яблок
* Нажмите "Hit(force to fall)" - чтобы яблоко "упало на землю", "Bite" - чтобы "откусить" часть яблока

# Тесты
* Настройте подключение к тестовой БД: ```nano common/config/test-local.php```
* ```./yii_test migrate```
* ```./vendor/bin/codecept run```

# Доп. инфо
Время за которое портится яблоко указано в параметрах приложения - params['fallenAppleLifetime']