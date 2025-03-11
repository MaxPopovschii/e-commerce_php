<?php
    class Router {
        public function run() {
            $controller = isset($_GET['controller']) ? $_GET['controller'] : 'FAQ';
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';
            
            $controllerFile = '../app/controllers/' . $controller . 'Controller.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = $controller . 'Controller';
                $obj = new $controllerClass();
                if (method_exists($obj, $action)) {
                    $obj->$action();
                } else {
                    echo "Azione non trovata";
                }
            } else {
                echo "Controller non trovato";
            }
        }
    }
?>