<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class PublicGpgKeyAlreadySetException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Public key was already set");
    }
}
