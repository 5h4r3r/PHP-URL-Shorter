<?
use App\Core\Application;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= $this->title ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="/public/css/default.css">
        <link rel="stylesheet" type="text/css" href="/public/css/template.css">
    </head>
    <body>
        <header>
            <div class="navigation">
                <div class="wrapper flex">
                    <div class="logotype"><a href="/">SHORT.ME</a></div>
                    <div class="items flex">
                    <? if (Application::isGuest()) : ?>
                        <div class="item">
                            <a href="/login">Войти</a>
                        </div>
                        <div class="item">
                            <a href="/register">Регистрация</a>
                        </div>
                    <? else : ?>
                        <div class="item">
                            <a href="#"><?=Application::$app->user->email;?></a>
                        </div>
                        <div class="item">
                            <a href="/logout">Выйти</a>
                        </div>
                    <? endif ?>
                    </div>
                </div>
            </div>
        </header>
        <div class="application">
            <div class="wrapper">
                <div class="content">
                    {{ content }}
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="/public/js/clipboard.min.js"></script>
        <script src="/public/js/main.js"></script>
    </body>
</html>