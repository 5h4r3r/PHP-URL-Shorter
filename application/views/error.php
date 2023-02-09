<?
$this->title = "Ошибка " . $exception->getCode();
?>
<div>Ошибка <?=$exception->getCode()?></div>
<br>
<div ><?=$exception->getMessage()?></div>