<?php

namespace Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions;

class DecryptionFailedException extends GpgClientBaseException
{
    public function __construct()
    {
        parent::__construct("Decryption failed");
    }
}
