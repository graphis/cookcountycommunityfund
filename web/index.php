<?php

require __DIR__ . '/../vendor/autoload.php';

Spark\Application::build()
->setConfiguration([
    Northwoods\CCCF\Configuration::class,
    Spark\Configuration\AurynConfiguration::class,
    Spark\Configuration\DiactorosConfiguration::class,
    Spark\Configuration\PayloadConfiguration::class,
    Spark\Configuration\PlatesResponderConfiguration::class,
    Spark\Configuration\RelayConfiguration::class,
    Spark\Configuration\WhoopsConfiguration::class,
])
->setMiddleware([
    Relay\Middleware\ResponseSender::class,
    Spark\Handler\ExceptionHandler::class,
    Spark\Handler\DispatchHandler::class,
    Spark\Handler\FormContentHandler::class,
    Spark\Handler\ActionHandler::class,
])
->setRouting(function (Spark\Directory $directory) {
    return $directory
    ->get('/[about]', 'Northwoods\CCCF\Domain\About')
    ->get('/board', 'Northwoods\CCCF\Domain\Board')
    ->get('/directory', 'Northwoods\CCCF\Domain\Directory')
    ; // end of routing
})
->run();
