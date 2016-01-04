<?php

namespace Northwoods\CCCF\Domain;

class Directory extends Domain
{
    public function __invoke(array $input)
    {
        return $this->payload()->withOutput([
            'active' => 'directory',
            'template' => 'directory',
        ]);
    }
}
