<?php

use App\Core\App;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Connection;
use App\Core\Router;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/helpers.php';

App::bind('config', require __DIR__ . '/../core/config.php');

App::bind('database', new QueryBuilder(
	Connection::make(App::get('config')['database'])
));

App::bind('request', Request::createFromGlobals());

$request = App::get('request');
$routes = "/../app/routes.php";

Router::define($routes)
    ->fire($request->getPathInfo(), $request->getMethod());