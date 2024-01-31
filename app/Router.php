<?php
namespace app;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'DELETE' => [],
        'PUT' => []
    ];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function delete($uri, $controller) {
        $this->routes['DELETE'][$uri] = $controller;
    }

    public function put($uri, $controller) {
        $this->routes['PUT'][$uri] = $controller;
    }
    
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $uri_explode = explode('/', $_SERVER['REQUEST_URI']);
        foreach ($uri_explode as $key => $elem) {
            if (is_numeric($elem)) {
                $uri_explode[$key] = '{id}';
            }
        }
        $uri_implode = implode('/', $uri_explode);
        $found = false;
        foreach ($this->routes[$method] as $route => $_) {
            if ($route === $uri_implode) {
                $uri_explode = explode('/', $uri);
                $id = end($uri_explode);
                call_user_func_array($this->routes[$method][$uri_implode], [$id]);
                $found = true;
                break;
            }
        }
        if (!$found) {
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 Not Found</h1>';
        }
    }
}
?>