<?php

require __DIR__ . '/../vendor/autoload.php';

$injector = new Auryn\Injector;

(new Northwoods\CCCF\Configuration)
    ->apply($injector);

$app = Spark\Application::boot($injector);

$app->setMiddleware([
    'Relay\Middleware\ResponseSender',
    'Spark\Handler\ExceptionHandler',
    'Spark\Handler\RouteHandler',
    'Spark\Handler\ContentHandler',
    'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function (Spark\Router $r) {
    $r->get('/[about]', 'Northwoods\CCCF\Domain\About');
    $r->get('/board', 'Northwoods\CCCF\Domain\Board');
    $r->get('/directory', 'Northwoods\CCCF\Domain\Directory');
});

$app->run();
