<?php

namespace Northwoods\CCCF\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

abstract class Domain implements DomainInterface
{
    protected function payload()
    {
        return (new Payload)->withStatus(Payload::OK);
    }
}
