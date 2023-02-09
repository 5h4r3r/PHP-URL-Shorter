<?
const APP_DIR = __DIR__ . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR;

require_once APP_DIR . "core" . DIRECTORY_SEPARATOR . "Autoload.php";

use App\Core\Autoload;
use App\Core\Application;

new Autoload();
new Application();

Application::$app->Run();
?>