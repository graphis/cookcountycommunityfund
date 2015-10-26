<?php

namespace Northwoods\CCCF\Domain;

class About extends Domain
{
    public function __invoke(array $input)
    {
        return $this->payload()->withOutput([
            'template' => 'about',
        ]);
    }
}
