<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey;

use Borzoni\SBFile\Components\SBFile\FileInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey\Classes\PrivateGpgKeyWithFakeCollaborators;

class PrivateGpgKeyComponentBuilder
{
    use GnupgFactoryMethod;

    public static function make(): PrivateGpgKeyInterface
    {
        $client = self::staticCreateGnupg();
        return new PrivateGpgKey($client);
    }

    /**
     * @param \gnupg                                          $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\FileInterface $SBFileMock
     *
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface
     */
    public static function makeWithFakeCollaborators(gnupg $gnupgMock, FileInterface $SBFileMock): PrivateGpgKeyInterface
    {
        return new PrivateGpgKeyWithFakeCollaborators($gnupgMock, $SBFileMock);
    }
}
