<?php
namespace App\Controllers;
/**
 * Class Controller - base controller of project
 */
class Controller
{
    private static $twig;

    public static function initTwig($twig)
    {
        self::$twig = $twig;
    }

    protected function render($template, $params = [])
    {
        echo self::$twig->render($template . ".html.twig", $params);
    }

}