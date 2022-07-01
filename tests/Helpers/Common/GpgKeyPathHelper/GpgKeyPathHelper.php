<?php

namespace Tests\Helpers\Common\GpgKeyPathHelper;

class GpgKeyPathHelper
{
    protected const DIR_NAME = 'gpg-keys';
    protected const PRIVATE_FILE = 'private.pgp';
    protected const PRIVATE_PASSPHRASE = '';
    protected const PUBLIC_FILE = 'public.pgp';

    /**
     * @return string
     */
    public static function getPrivateGpgKeyPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::DIR_NAME . DIRECTORY_SEPARATOR . self::PRIVATE_FILE;
    }

    /**
     * @return string
     */
    public static function getPrivateGpgKeyPassphrase(): string
    {
        return self::PRIVATE_PASSPHRASE;
    }

    /**
     * @return string
     */
    public static function getPublicGpgKeyPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::DIR_NAME . DIRECTORY_SEPARATOR . self::PUBLIC_FILE;
    }
}
