<?
namespace App\Core\Exception;

class NotFound extends \Exception
{
    protected $message = "Запрашиваемая страница не найдена на этом сервере";
    protected $code = 404;
}
