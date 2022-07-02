<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes;

use Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManager;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;

class GpgManagerWithFakeStringClient extends GpgManager
{
    public const TEST_CLIENT_CODE = 'TEST';

    /**
     * @return void
     */
    protected function initClients(): void
    {
        $this->clients = [self::TEST_CLIENT_CODE => GpgClientComponentBuilder::make()];
    }
}
