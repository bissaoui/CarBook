<?php

// Get container
$container = $app->getContainer();
// Register component on container
$container['view'] = function ($container) {
	$dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/app/views', [
        'cache' => false
    ]);
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php','',$container['request']->getUri()->getBasePath()),'/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};


$container['pdo']=function(){

    $dsn='mysql:dbname=location;host=localhost';
    $user='root';
    $pass='';
    $pdo= new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    return $pdo;
};