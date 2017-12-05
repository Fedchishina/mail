<?php
/*
 * definition of constants
 */
define('ROOT', dirname(dirname(__FILE__)));
session_start();

require_once ROOT . '/vendor/autoload.php';
/*
 * general settings
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
 * including
 */
use Routing\Router;
use App\Controllers\Controller;

/**
 * loading twig
 */
$loader = new Twig_Loader_Filesystem(ROOT . '/resources/views');
$twig = new Twig_Environment($loader);
$twig->addGlobal('_session', $_SESSION);
$twig->addGlobal('_get', $_GET);
Controller::initTwig($twig);

/**
 * loading routes
 */
try {
    $router = new Router();
    $router->run();
}
catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo '<pre>'. $e->getMessage() . '</pre><br>';
    echo '<pre>'. $e->getTraceAsString() . '</pre><br>';
    exit;
}