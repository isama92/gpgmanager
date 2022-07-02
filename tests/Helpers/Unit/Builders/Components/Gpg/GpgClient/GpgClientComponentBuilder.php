<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\Classes\GpgClientWithFakeCollaborators;

class GpgClientComponentBuilder
{
    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    public static function make(): GpgClientInterface
    {
        return new GpgClient();
    }

    /**
     * @param \gnupg $gnupgMock
     * @param \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface $privateGpgKeyMock
     * @param \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface $publicGpgKeyMock
     *
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    public static function makeWithFakeCollaborators(
        gnupg $gnupgMock,
        PrivateGpgKeyInterface $privateGpgKeyMock,
        PublicGpgKeyInterface $publicGpgKeyMock
    ): GpgClientInterface {
        return new GpgClientWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
    }
}
