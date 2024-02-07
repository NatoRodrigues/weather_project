<?php 

namespace routes;

class Router {
    private string $controller = 'Web'; // <- vai armazenar o nome da classe principal.
    private string $method = '';
    private array $param = [];

   
    public function __construct(){

        $router = $this->url();

        if (file_exists('src/Controller' . ucfirst($router[0] . 'php'))) {
            $this->controller = $router[0];
            unset($router[0]);
            
        }else {
            $this->controller = 'System';
            
        }

        $Controller_class_name = "\\src\\Controller\\" . ucfirst($this->controller);
        $object = new $Controller_class_name;

        if (isset($router[1]) && method_exists($Controller_class_name, $router[1])) {
            $this->method = $router[1];
            unset($router[1]);

        } else {
            $this->method = 'home';
    }

    if ($router) {
        $this->param = array_values($router);    
    } else{
        $this->param = [];
    }
    call_user_func_array([$object,$this->method], [$this->param]);

}

    private function url(){
        $router_param = filter_input(INPUT_GET, 'router', FILTER_SANITIZE_URL);
            if($router_param !== null){
                $parse_url = explode('/', $router_param);
                return $parse_url;
            }else {
                return [];
            }
    }

}

?>