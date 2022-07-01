<?php

namespace Borzoni\GpgManager\Components\GpgClient\Exceptions;

class DecryptionFailedException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Decryption failed");
    }
}
