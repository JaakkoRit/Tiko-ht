<?php

$router->get('/', 'HomeController@index');

$router->get('/student-home', 'StudentController@index');
$router->get('/student-login', 'StudentController@create');
$router->post('/student-login', 'StudentController@save');
$router->get('/logout', 'StudentController@destroy');

$router->get('/teacher-home', 'TeacherController@index');
$router->get('/teacher-login', 'TeacherController@create');
$router->post('/teacher-login', 'TeacherController@save');

$router->get('/admin-home', 'AdminController@index');
$router->get('/admin-login', 'AdminController@create');
$router->post('/admin-login', 'AdminController@save');

$router->get('/student-registration', 'DevController@create');
$router->post('/student-registration', 'DevController@save');
$router->get('/teacher-registration', 'DevController@create2');
$router->post('/teacher-registration', 'DevController@save2');
$router->get('/admin-registration', 'DevController@createAdmin');
$router->post('/admin-registration', 'DevController@saveAdmin');

$router->get('/session', 'SessionController@show');
$router->post('/session', 'SessionController@save');

$router->get('/session-report', 'ReportController@showSessionRaport');
$router->get('/tasklistsession-report', 'ReportController@showTaskListSessionReport');

$router->get('/tasks', 'TaskController@index');
$router->get('/tasks/create', 'TaskController@create');
$router->post('/tasks/save', 'TaskController@save');
$router->get('/tasks/edit', 'TaskController@edit');
$router->post('/tasks/update', 'TaskController@update');
$router->post('/tasks/delete', 'TaskController@delete');

$router->get('/tasklists', 'TaskListController@index');
$router->get('/tasklists/create', 'TaskListController@create');
$router->post('/tasklists/save', 'TaskListController@save');
$router->post('/tasklists/delete', 'TaskListController@delete');
$router->get('/show-tasklist', 'TaskListController@show');
$router->get('/edit-tasklist', 'TaskListController@edit');
$router->post('/tasklists/update', 'TaskListController@update');
$router->post('/delete-taskfromtasklist', 'TaskListController@deleteTask');

$router->get('/sessions-management', 'SessionManagementController@index');
$router->get('/sessions-management/create', 'SessionManagementController@create');
$router->post('/sessions-management/save', 'SessionManagementController@save');

$router->get('/answers/create', 'AnswerController@create');
$router->post('/answers/save', 'AnswerController@save');
$router->get('/answers/delete', 'AnswerController@delete');