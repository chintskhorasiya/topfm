<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'topfm',
	);
	var $test = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
	);
	var $topfm = array(
		'driver' => 'mysql',
		'persistent' => true,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'topfm',
	);
}
?>