<?php

use Aura\SqlQuery\QueryFactory;
use DI\ContainerBuilder;
use League\Plates\Engine;
use \Delight\Auth\Auth;


$containerBuilder = new ContainerBuilder;

$containerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('views');
    },
    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    },
    PDO::class => function() {
        return new PDO('mysql:host=localhost;dbname=test', 'root', '');
    },
    Auth::class => function() {
        return new Auth(new PDO('mysql:host=localhost;dbname=test', 'root', ''));
    },
    ImageManager::class => function() {
        return new ImageManager(array('driver' => 'imagick'));
    },
]);
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\HomeController','index']);
    $r->addRoute('GET', '/home/', ['App\controllers\HomeController','index']);
    $r->addRoute('GET', '/login/', ['App\controllers\HomeController','login']);
    $r->addRoute('POST', '/loginBackend/', ['App\controllers\HomeController','loginBackend']);
    $r->addRoute('GET', '/logOut/', ['App\controllers\HomeController','logOut']);
    $r->addRoute('GET', '/profale/', ['App\controllers\HomeController','profale']);
    $r->addRoute('GET', '/editCategories/', ['App\controllers\HomeController','editCategories']);
    $r->addRoute('POST', '/deleteCaterory/', ['App\controllers\HomeController','deleteCaterory']);
    $r->addRoute('POST', '/updateCaterory/', ['App\controllers\HomeController','updateCaterory']);
    $r->addRoute('POST', '/addCategory/', ['App\controllers\HomeController','addCategory']);
    $r->addRoute('GET', '/addProduct/', ['App\controllers\HomeController','addProduct']);
    $r->addRoute('POST', '/addProductBackend/', ['App\controllers\HomeController','addProductBackend']);
    $r->addRoute('POST', '/deleteProduct/', ['App\controllers\HomeController','deleteProduct']);
    $r->addRoute('POST', '/updateProduct/', ['App\controllers\HomeController','updateProduct']);
    // {id} must be a number (\d+)
    // $r->addRoute('GET', '/home/{idCastom:\d+}', ['HomeController','about']);
    // // The /{title} suffix is optional
    //$r->addRoute('GET', '/home/{id:\d+}[/{title}]', ['HomeController','index']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        exit('... 404 Not Found');
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        exit('405 Method Not Allowed');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($handler,$vars);
        break;
}
?>