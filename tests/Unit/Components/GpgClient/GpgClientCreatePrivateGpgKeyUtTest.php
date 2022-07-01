<?php

namespace Tests\Unit\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;

class GpgClientCreatePrivateGpgKeyUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createPrivateGpgKey_correctInstanceReturned(): void
    {
        // Arrange
        $client = new GpgClient();

        // Act
        $privateGpgKey = $client->createPrivateGpgKey();

        // Assert
        $this->assertInstanceOf(PrivateGpgKey::class, $privateGpgKey);
    }
}
