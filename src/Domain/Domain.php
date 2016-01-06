<?php

namespace Northwoods\CCCF\Domain;

use Equip\Adr\DomainInterface;
use Equip\Payload;

abstract class Domain implements DomainInterface
{
    protected function payload()
    {
        return (new Payload)->withStatus(Payload::OK);
    }
}
