<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class PrivateGpgKeyAlreadySetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Private key was already set");
    }
}
