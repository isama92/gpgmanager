<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class PublicGpgKeyNotSetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Public key has not been set");
    }
}
