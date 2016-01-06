<?php

if (PHP_SAPI === 'cli-server') {
    $ext = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION);
    if ($ext && $ext !== 'php') {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

Equip\Application::build()
->setConfiguration([
    Equip\Configuration\AurynConfiguration::class,
    Equip\Configuration\DiactorosConfiguration::class,
    Equip\Configuration\EnvConfiguration::class,
    Equip\Configuration\PayloadConfiguration::class,
    Equip\Configuration\PlatesResponderConfiguration::class,
    Equip\Configuration\RelayConfiguration::class,
    Equip\Configuration\WhoopsConfiguration::class,
    // ...
    Northwoods\CCCF\Configuration\GuzzleConfiguration::class,
    Northwoods\CCCF\Configuration\PlatesConfiguration::class,
])
->setMiddleware([
    Relay\Middleware\ResponseSender::class,
    Equip\Handler\ExceptionHandler::class,
    Equip\Handler\DispatchHandler::class,
    Equip\Handler\FormContentHandler::class,
    Equip\Handler\ActionHandler::class,
])
->setRouting(function (Equip\Directory $directory) {
    return $directory
    ->get('/[about]', 'Northwoods\CCCF\Domain\About')
    ->get('/board', 'Northwoods\CCCF\Domain\Board')
    ->get('/directory', 'Northwoods\CCCF\Domain\Directory')
    ; // end of routing
})
->run();
