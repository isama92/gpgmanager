<?php

namespace Borzoni\GpgManager\Components\GpgClient\Exceptions;

class PublicGpgKeyAlreadySetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Public key was already set");
    }
}
