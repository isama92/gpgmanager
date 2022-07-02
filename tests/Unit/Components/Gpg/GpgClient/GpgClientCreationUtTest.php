<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;

class GpgClientCreationUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function gpgClientConstruct_ObjectCreated(): void
    {
        // Arrange
        $client = GpgClientComponentBuilder::make();

        // Assert
        $this->assertInstanceOf(GpgClient::class, $client);
    }
}
