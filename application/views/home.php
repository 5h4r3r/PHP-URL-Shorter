<?
use App\Core\Application;
use App\Core\Shorter;

$this->title = "SHORT.ME! - Сокращение ссылок";
?>
<div class="shortener">
    <div class="heading">Сокращение ссылок</div>
    <div class="description">На этой странице вы можете сделать из длинной и сложной ссылки простую. Такие ссылки удобнее использовать в ваших записях и сообщениях.</div>
    <div>
        <form method="post" id="shorter">
            <input type="text" class="field" name="url" placeholder="Ссылка, которую вы хотите сократить">
            <button type="submit">Сократить</button>
        </form>
    </div>
    <div class="clipboard" style="display:none">
        <input type="text" class="field" id="clipboard">
        <button class="btn" data-clipboard-target="#clipboard">Скопировать</button>
    </div>
</div>
<? if (!Application::isGuest()) : ?>
    <div class="shorts-block">
        <h3>Ваши ссылки</h3>
        <div class="shorts">
            <?
            $shorter = new Shorter();
            $shorts = $shorter->get(Application::$app->user->id);
            $protocol = ($_SERVER["HTTPS"] == "on") ? "https" : "http";

            if ($shorts !== false) {
                rsort($shorts);
                
                foreach($shorts as $short) {?>
                    <?$url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/" . $short["alias"];?>
                    <div class="short">
                        <a href="<?=$url?>"><?=$url?></a>
                        <div><?=$short["link"]?></div>
                        <div>Переходы: <?=$short["hits"]?></div>
                        <input type="hidden" id="id-<?=$short["alias"]?>" value="<?=$url?>">
                        <button class="btn" data-clipboard-target="#id-<?=$short["alias"]?>">Скопировать</button>
                    </div>
                <? }
            } else {
                echo "Пока тут пусто :(";
            }
            ?>
        </div>
    </div>
<? endif; ?>