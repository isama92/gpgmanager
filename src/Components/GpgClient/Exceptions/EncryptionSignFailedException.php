<?php

namespace Borzoni\GpgManager\Components\GpgClient\Exceptions;

class EncryptionSignFailedException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("EncryptionSign failed");
    }
}
