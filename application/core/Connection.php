<?

namespace App\Core;

class Connection
{
    public \PDO $pdo;

    public function __construct($config)
    {
        $this->pdo = new \PDO("mysql:host={$config["host"]};dbname={$config["dbname"]}", $config["user"], $config["password"]);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
