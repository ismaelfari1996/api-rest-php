<?php

class App{
    protected $db;
    protected $routes = [
        'GET' => [
            '/user/{id}' => 'UserController@getById',
            '/user' => 'UserController@getAllUsers',
        ],
        'POST' => [
            '/user' => 'UserController@save',
        ],
        'PUT' => [
            '/users/{id}' => 'UserController@update',
        ],
        'DELETE' => [
            '/users/{id}' => 'UserController@destroy',
        ],
    ];

    public function __construct($db){
        $this->db=$db;
    }

    public function run(){
        // se obtiene la uri
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method=$_SERVER['REQUEST_METHOD'];
        $uri = explode('/', $uri);
        $controllerName = ucfirst($uri[2]) . 'Controller';
        // carga del controlador
        try{
            require_once 'controller/'.$controllerName.".php";
            $controller=new $controllerName($this->db);
            $uri=$this->validateURL($uri);
            $route = $this->routes[$method]["/".$uri[2]];
            [$controllerName, $methodName] = explode('@', $route);
            if(sizeof($uri)>3){
                $controller->$methodName($uri[3]);
            }else{
            $controller->$methodName();
            }

        }catch(Exception $e){
            echo json_encode($e->getMessage());
        }
    }

    private function validateURL($url){ 
        if(sizeof($url)>3){
            $url[2]=$url[2]."/{id}";
            return $url;
        }
        return $url;
    }
}