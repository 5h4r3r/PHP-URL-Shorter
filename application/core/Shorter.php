<?

namespace App\Core;

class Shorter
{
    public function save($user = 0, $url)
    {
        $link = $this->verify($url);
        $alias = $this->alias();

        if ($link == false)
            return false;

        $sql = Application::$app->connection->prepare("INSERT INTO urls(alias,link,user) VALUES (:alias,:link,:user)");
        $sql->bindParam(":alias", $alias);
        $sql->bindParam(":link", $link);
        $sql->bindParam(":user", $user);
        $sql->execute();

        return $alias;
    }

    public function redirect($alias)
    {
        $sql = Application::$app->connection->prepare("SELECT link FROM urls WHERE alias = :alias");
        $sql->execute(array(":alias" => $alias));

        if ($sql->rowCount() > 0) {
            $this->update($alias);
            header("Location: " . $sql->fetch()[0]);
        } else {
            return;
        }
    }

    public function get($user)
    {
        $sql = Application::$app->connection->prepare("SELECT * FROM urls WHERE user = :user");
        $sql->execute(array(":user" => $user));

        if ($sql->rowCount() > 0) {
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($alias)
    {
        $sql = Application::$app->connection->prepare("UPDATE urls SET hits = hits + 1 WHERE alias = :alias");
        $sql->execute(array(":alias" => $alias));
    }

    private function alias()
    {
        $salt = str_split("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789");
        $alias = "";

        for ($i = 0; $i < 7; $i++) {
            $char = rand(0, count($salt)-1);
            $alias .= $salt[$char];
        }

        return $alias;
    }

    private function verify($url)
    {
        if (!empty($url)) {
            return $url;
        } else {
            return false;
        }
    }
}
