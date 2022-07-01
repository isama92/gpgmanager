<?php

namespace Tests\Unit\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use gnupg;

class GpgClientGetClientUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function getClient_correctInstanceReturned(): void
    {
        // Arrange
        $client = new GpgClient();

        // Act
        $gnupg = $client->getClient();

        // Assert
        $this->assertInstanceOf(gnupg::class, $gnupg);
    }
}
