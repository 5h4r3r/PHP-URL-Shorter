<?
namespace App\Core;

class User
{
    public function get($email)
    {
        $sql = Application::$app->connection->prepare("SELECT users.id, users.email, users.password FROM users WHERE email = :email");
        $sql->execute(array(":email" => $email));

        $data = $sql->fetchObject(static::class);

        return $data;
    }

    public function add($data)
    {
        $sql = Application::$app->connection->prepare("INSERT INTO users(email,password) VALUES (:email,:password)");
        $sql->bindParam(":email", $data["email"]);
        $sql->bindParam(":password", password_hash($data["password"], PASSWORD_DEFAULT));
        $sql->execute();

        return $this->get($data["email"]);
    }
}