<?php

namespace Borzoni\GpgManager\Components\GpgClient\Exceptions;

class PrivateGpgKeyNotSetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Private key has not been set");
    }
}
