<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class EncryptionSignFailedException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("EncryptionSign failed");
    }
}
