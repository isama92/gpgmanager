<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
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
