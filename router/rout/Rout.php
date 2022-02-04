<?php
class Rout
{
    public $spisok_url;
    public function __construct($mod)
    {
        $this->spisok_url = $mod;
    }
    public function add_rout($uri, $page)
    {
        $this->spisok_url[$uri] = $page;
    }
    public function enable()
    {
        $query = $_GET['url'];
        foreach ($this->spisok_url as $key => $rout) {
            if ($key == '/' . $query) {
                require __DIR__ . "/../views/{$rout}";
                exit;
            }
        }
        require __DIR__ . "/../views/404.php";
    }
}
