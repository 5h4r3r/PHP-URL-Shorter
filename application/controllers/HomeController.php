<?php
namespace App\Controller;

use App\Core\Application;
use App\Core\Shorter;

class HomeController
{
    public static function Home()
    {
        return Application::$app->view->render("home");
    }

    public static function Shorter()
    {
        if (Application::$app->isPost()) {
            if (isset($_POST['url']))
            {
                $shorter = new Shorter();
                if (Application::$app->user !== null) {
                    $alias = $shorter->save(Application::$app->user->id, $_POST['url']);
                } else {
                    $alias = $shorter->save(0, $_POST['url']);
                }

                if (!$alias) {
                    Application::$app->setStatusCode(404);
                    return "Укажите ссылку!";
                }

                $protocol = ($_SERVER["HTTPS"] == "on") ? "https" : "http";
                $url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/" . $alias;
                
                if (Application::$app->user !== null) {
                    return true;
                } else {
                    return $url;
                }
            }
        }
    }
}