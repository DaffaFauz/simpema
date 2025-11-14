<?php 
class App{
    protected $controller = 'Home';
     protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // Cek controller
        if(!empty($url) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0] ;
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Cek method
        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Cek params
        if(!empty($url)) {
            $this->params = array_values($url);
            unset($url);
        
        }

        // Jalankan controller dan method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}