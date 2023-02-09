<?
namespace App\Core;

class View
{
    public string $title = "";
    public string $layout = "default";

    public function render($view, $params = [])
    {
        $content = $this->renderView($view, $params);
        $layout = $this->renderLayout();

        return str_replace("{{ content }}", $content, $layout);
    }

    protected function renderLayout()
    {
        ob_start();
        include_once APP_DIR . "views" . DIRECTORY_SEPARATOR . "layouts" . DIRECTORY_SEPARATOR . $this->layout . ".php";
        return ob_get_clean();
    }

    protected function renderView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        
        if (is_array($view)) {
            ob_start();
            include_once APP_DIR . "views" . DIRECTORY_SEPARATOR . $view[1] . ".php";
            return ob_get_clean();
        } else {
            ob_start();
            include_once APP_DIR . "views" . DIRECTORY_SEPARATOR . $view . ".php";
            return ob_get_clean();
        }
    }
}