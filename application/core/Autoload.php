<?
namespace App\Core;

class Autoload
{
    private array $autoload;

    public function __construct()
    {
        $this->autoload = require_once APP_DIR . "configs" . DIRECTORY_SEPARATOR . ".autoload.php";
        
        spl_autoload_register(
            array(
                $this, "Load"
            )
        );
    }

    private function Load($class)
    {
        require_once APP_DIR . $this->autoload[$class];
    }
}