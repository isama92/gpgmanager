<?php

namespace Tests\Unit\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgKey\PublicGpgKey;

class GpgClientCreatePublicGpgKeyUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createPublicGpgKey_correctInstanceReturned(): void
    {
        // Arrange
        $client = new GpgClient();

        // Act
        $publicGpgKey = $client->createPublicGpgKey();

        // Assert
        $this->assertInstanceOf(PublicGpgKey::class, $publicGpgKey);
    }
}
