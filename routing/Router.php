<?php
namespace Routing;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * return URI without GET parameters
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri =  trim($_SERVER['REQUEST_URI'], '/');
            $str=strpos($uri, "?");
            if ($str === false) {
                return $uri;
            }
            return substr($uri, 0, $str);

        }
        return false;
    }

    /**
     * calling controller method on sent router in URI
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                //get parameters
                $segments = explode('/', $internalRoute);
                $parameters = $segments;
                //get name of controller
                $controllerName = '\App\Controllers\\' . ucfirst(array_shift($segments).'Controller');
                //get name method of controller
                $actionName = 'action'.ucfirst(array_shift($segments));
                //creating object of controller
                $controllerObject = new $controllerName();
                //calling method of controller (with sending of parameters)
                call_user_func_array(array($controllerObject, $actionName), $parameters);
                break;
            }
        }
    }
}