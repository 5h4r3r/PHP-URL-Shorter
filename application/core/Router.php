<?
namespace App\Core;

use App\Core\Application;
use App\Core\Shorter;
use App\Core\Exception\NotFound;

class Router
{
    public function route()
    {
        $callback = $this->callback() ?? false;

        $shorter = new Shorter();
        $shorter->redirect(trim(Application::$app->request(), "/"));

        if ($callback === false) {
            throw new NotFound();
        }

        if (is_string($callback)) {
            return Application::$app->view->render($callback);
        }

        return call_user_func($callback);
    }

    public function callback()
    {
        $url = Application::$app->request();
        $method = Application::$app->method();

        $url = trim($url, "/");
        
        $routes = require_once APP_DIR . "/configs/.routes.php";
        $arRoutes = $routes[$method] ?? [];

        foreach ($arRoutes as $route => $callback) {
            if ($route == $url) {
                return $callback;
            }
        }

        return false;
    }
}