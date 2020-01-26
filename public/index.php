<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url;//change from Phalcon\Url
use Phalcon\Db\Adapter\Pdo\Mysql;
//use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Files as Manager; //add on miniPC
use Phalcon\Session\Adapter\Stream;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;

use Phalcon\Mvc\Router;

$router = new Router();



// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();
$container->set(
    'flash',
    function () {
        return new FlashDirect();
    }
);

// Set up the flash session service
$container->set(
    'flashSession',
    function () {
        return new FlashSession();
    }
);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'roma',
                'password' => 'taraNtul230678!',
                'dbname'   => 'phalcon',
            ]
        );
    }
);
/*
$di->set('router', function() {

    $router = new Phalcon\Mvc\Router();

    $router->add("/address/:params", array(
        'controller' => 'products',
        'params' => 1,
    ));

    return $router;
});
 */

$container->set(
    'session',
    function () {
        $session = new Manager();
        /*$files   = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );*/
        // $session->setAdapter($files);

        $session->start();

        return $session;
    }
);

$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

