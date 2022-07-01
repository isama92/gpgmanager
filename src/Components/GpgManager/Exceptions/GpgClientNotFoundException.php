<?php

namespace Borzoni\GpgManager\Components\GpgManager\Exceptions;

class GpgClientNotFoundException extends GpgManagerBaseException
{
    /**
     * @param string $clientCode
     */
    public function __construct(string $clientCode)
    {
        parent::__construct("GpgClient not found ({$clientCode})");
    }
}
