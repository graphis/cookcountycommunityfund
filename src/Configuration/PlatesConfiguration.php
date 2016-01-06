<?php

namespace Northwoods\CCCF\Configuration;

use Auryn\Injector;
use League\Plates\Engine;
use Northwoods\CCCF\Plates\DirectoryExtension;
use Equip\Configuration\ConfigurationInterface;

class PlatesConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->define(Engine::class, [
            ':directory' => __DIR__ . '/../../templates',
        ]);

        $injector->prepare(Engine::class, [$this, 'prepareTemplates']);
    }

    public function prepareTemplates(Engine $template, Injector $injector)
    {
        $template->addData([
            'pages' => $this->getPages(),
        ]);

        $template->setFileExtension('phtml');

        $template->loadExtension(new DirectoryExtension);
    }

    protected function getPages()
    {
        return [
            '/' => 'About',
            '/board' => 'Board',
            '/directory' => 'Directory',
        ];
    }
}
