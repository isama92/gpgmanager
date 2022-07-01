<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgKey;

use Borzoni\SBFile\Components\SBFile\SBFile;
use Borzoni\GpgManager\Components\GpgKey\PublicGpgKey;
use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\GpgKey\Classes\PublicGpgKeyWithFakeCollaborators;

class PublicGpgKeyComponentBuilder
{
    use GnupgFactoryMethod;

    public static function make(): PublicGpgKey
    {
        $client = self::staticCreateGnupg();
        return new PublicGpgKey($client);
    }

    /**
     * @param \gnupg                                       $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\SBFile $SBFileMock
     *
     * @return \Tests\Helpers\Unit\Builders\Components\GpgKey\Classes\PublicGpgKeyWithFakeCollaborators
     */
    public static function makeWithFakeCollaborators(gnupg $gnupgMock, SBFile $SBFileMock): PublicGpgKey
    {
        return new PublicGpgKeyWithFakeCollaborators($gnupgMock, $SBFileMock);
    }
}
