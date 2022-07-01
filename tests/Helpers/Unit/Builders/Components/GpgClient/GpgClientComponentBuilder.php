<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\GpgKey\PublicGpgKey;
use gnupg;
use Tests\Helpers\Unit\Builders\Components\GpgClient\Classes\GpgClientWithFakeCollaborators;

class GpgClientComponentBuilder
{
    /**
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient
     */
    public static function make(): GpgClient
    {
        return new GpgClient();
    }

    /**
     * @param \gnupg                                                  $gnupgMock
     * @param \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey $privateGpgKeyMock
     * @param \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey  $publicGpgKeyMock
     *
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient
     */
    public static function makeWithFakeCollaborators(gnupg $gnupgMock, PrivateGpgKey $privateGpgKeyMock, PublicGpgKey $publicGpgKeyMock): GpgClient
    {
        return new GpgClientWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
    }
}
