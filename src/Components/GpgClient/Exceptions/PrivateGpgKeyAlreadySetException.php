<?php

namespace Borzoni\GpgManager\Components\GpgClient\Exceptions;

class PrivateGpgKeyAlreadySetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Private key was already set");
    }
}
