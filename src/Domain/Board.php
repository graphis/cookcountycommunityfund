<?php

namespace Northwoods\CCCF\Domain;

class Board extends Domain
{
    public function __invoke(array $input)
    {
        return $this->payload()->withOutput([
            'active' => 'board',
            'template' => 'board',
        ]);
    }
}
