<?php

namespace Tests\Unit\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Tests\Helpers\Unit\Builders\Components\GpgClient\GpgClientComponentBuilder;

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
