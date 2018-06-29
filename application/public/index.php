<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$loader = new Loader();

$loader->registerDirs([
	APP_PATH . '/controllers',
	APP_PATH . '/models',
]);

$loader->register();

$di = new FactoryDefault();

$di->set('view', function(){
	$view = new View();
	$view->setViewsDir(APP_PATH . '/views');

	return $view;
});

$di->set('url', function(){
	$url = new UrlProvider();
	$url->setBaseUri('/');

	return $url;
});

$di->set('db', function(){
	$dbAdapter = new DbAdapter([
		'host' => '172.18.0.2',
		'username' => 'phalcon',
		'password' => 'secret',
		'dbname' => 'phalcondb'
	]);

	return $dbAdapter;
});

$app = new Application($di);

try{
	$response = $app->handle();
	$response->send();
}catch(\Exception $e) {
	echo 'Exception: ' . $e->getMessage();
	echo '<pre>';
	echo $e->getTraceAsString();
}
