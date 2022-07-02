<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class EncryptionFailedException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Encryption failed");
    }
}
