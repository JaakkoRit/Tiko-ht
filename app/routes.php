<?php

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');

$router->get('/tasks', 'TasksController@index');
$router->post('/tasks', 'TasksController@save');

$router->get('/register', 'UsersController@create');
$router->post('/register', 'UsersController@save');

$router->get('/login', 'SessionController@create');
$router->post('/login', 'SessionController@save');
$router->get('/logout', 'SessionController@destroy');

$router->get('/esimerkki', 'EsimerkkiController@miumauku');
$router->post('/esimerkki', 'EsimerkkiController@save');