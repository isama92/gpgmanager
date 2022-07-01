<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgKey;

use Borzoni\SBFile\Components\SBFile\SBFile;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\GpgKey\Classes\PrivateGpgKeyWithFakeCollaborators;

class PrivateGpgKeyComponentBuilder
{
    use GnupgFactoryMethod;

    public static function make(): PrivateGpgKey
    {
        $client = self::staticCreateGnupg();
        return new PrivateGpgKey($client);
    }

    /**
     * @param \gnupg                                       $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\SBFile $SBFileMock
     *
     * @return \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    public static function makeWithFakeCollaborators(gnupg $gnupgMock, SBFile $SBFileMock): PrivateGpgKey
    {
        return new PrivateGpgKeyWithFakeCollaborators($gnupgMock, $SBFileMock);
    }
}
