<?
namespace App\Core;

use App\Core\Exception\NotFound;

class Application
{
    public static Application $app;
    public Session $session;
    public Connection $connection;
    public Router $router;
    public View $view;
    public ?User $user;

    public function __construct()
    {
        self::$app = $this;
        $this->session = new Session();
        $this->connection = new Connection(require_once APP_DIR . "/configs/.settings.php");
        $this->router = new Router();
        $this->view = new View();
        $this->user = null;

        $session = $this->session->get("user");

        if ($session) {
            $user = new User;
            $this->user = $user->get($session);
        }
    }

    public function Run()
    {
        try {
            echo $this->router->route();
        } catch (\Exception $exception) {
            echo $this->view->render("error", [
                "exception" => $exception
            ]);
        }
    }

    public function request() {
        return $_SERVER["REDIRECT_URL"] ?? "home";
    }

    public function method()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet()
    {
        return $this->method() === "get";
    }

    public function isPost()
    {
        return $this->method() === "post";
    }

    public function getBody()
    {
        $body = array();

        if ($this->method() === "get") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, \FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === "post") {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, \FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("Location: " . $url);
    }

    public function Login(User $user)
    {
        $this->user = $user;
        $this->session->set("user", $user->email);
    }

    public function Logout()
    {
        $this->user = null;
        $this->session->remove("user");
    }
}