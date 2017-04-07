<?php
return [
	'database' => [
		'name' => 'todos',
		'username' => 'homestead',
		'password' => 'secret',
		'connection' => 'mysql:host=127.0.0.1', //'pgsql:host=dbstud2.sis.uta.fi',
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	]
];