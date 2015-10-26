<?php

namespace Northwoods\CCCF;

use Auryn\Injector;

class Configuration
{
    public function apply(Injector $injector)
    {
        // Expect HTML using Plates
        $injector->prepare('Spark\Responder\FormattedResponder', function ($responder) {
            return $responder->withFormatters([
                'Spark\Formatter\PlatesFormatter' => '1.0',
            ]);
        });

        // Configure Plates template directory
        $injector->define('League\Plates\Engine', [
            ':directory' => __DIR__ . '/../templates',
        ]);
    }
}
