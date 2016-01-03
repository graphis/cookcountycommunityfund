<?php

namespace Northwoods\CCCF;

use Auryn\Injector;
use League\Plates\Engine;
use Spark\Directory;
use Spark\Configuration\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        // Configure Plates template directory
        $injector->define(Engine::class, [
            ':directory' => __DIR__ . '/../templates',
        ]);

        $injector->prepare(Engine::class, [$this, 'prepareTemplates']);
    }

    protected function getPages()
    {
        return [
            '/' => 'About',
            '/board' => 'Board',
            '/directory' => 'Directory',
        ];
    }

    public function prepareTemplates(Engine $template, Injector $injector)
    {
        $template->addData([
            'pages' => $this->getPages(),
        ]);

        $template->setFileExtension('phtml');
    }
}
