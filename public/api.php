<?php
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = New \SlimController\Slim(array(
    'templates.path'             => 'templates',
    //'controller.class_prefix'    => '\\Taxonomia\\Controller',
    //'controller.method_suffix'   => 'Action',
    //'controller.template_suffix' => 'php',
));

//log
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('var/log/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

$app->addRoutes(include 'config/routes.php');

// Run app
$app->run();