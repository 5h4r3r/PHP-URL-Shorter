<?php
namespace App\Controller;

use App\Core\Application;
use App\Core\User;

class UserController
{

    public static function Login()
    {
        if (Application::$app->isPost()) {
            $user = new User;
            $getUser = $user->get(Application::$app->getBody()["email"]);
            
            if (!$getUser) {
                Application::$app->setStatusCode(404);
                return "Пользователь не найден!";
            }
            
            if (!password_verify(Application::$app->getBody()["password"], $getUser->password)) {
                Application::$app->setStatusCode(404);
                return "Неверный пароль";
            }
            
            Application::$app->Login($getUser);
            return Application::$app->redirect("/");
        }

        return Application::$app->view->render("login");
    }

    public static function Register()
    {
        if (Application::$app->isPost()) {
            $user = new User;
            $getUser = $user->get(Application::$app->getBody()["email"]);

            if ($getUser) {
                Application::$app->setStatusCode(404);
                return "Пользователь уже зарегистрирован!";
            }

            if (!filter_var(Application::$app->getBody()["email"], FILTER_VALIDATE_EMAIL)) {
                Application::$app->setStatusCode(404);
                return "Неверный формат почты!";
            }

            if (strlen(Application::$app->getBody()["password"]) < 6) {
                Application::$app->setStatusCode(404);
                return "Минимальная длина пароля 6 символов!";
            }

            $addUser = $user->add(Application::$app->getBody());

            Application::$app->Login($addUser);
            return Application::$app->redirect("/");
        }

        return Application::$app->view->render("register");
    }

    public static function Logout()
    {
        Application::$app->Logout();
        Application::$app->redirect("/");
    }
}