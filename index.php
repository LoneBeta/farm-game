<?php

include 'vendor/autoload.php';

$container = new \DI\Container();

$farmService = $container->get('FarmGame\\Service\\FarmService');

var_dump($farmService->execute());