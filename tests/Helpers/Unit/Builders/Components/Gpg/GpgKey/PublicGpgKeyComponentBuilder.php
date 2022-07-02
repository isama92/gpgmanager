<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey;

use Borzoni\SBFile\Components\SBFile\FileInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey\Classes\PublicGpgKeyWithFakeCollaborators;

class PublicGpgKeyComponentBuilder
{
    use GnupgFactoryMethod;

    public static function make(): PublicGpgKeyInterface
    {
        $client = self::staticCreateGnupg();
        return new PublicGpgKey($client);
    }

    /**
     * @param \gnupg                                          $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\FileInterface $SBFileMock
     *
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface
     */
    public static function makeWithFakeCollaborators(gnupg $gnupgMock, FileInterface $SBFileMock): PublicGpgKeyInterface
    {
        return new PublicGpgKeyWithFakeCollaborators($gnupgMock, $SBFileMock);
    }
}
