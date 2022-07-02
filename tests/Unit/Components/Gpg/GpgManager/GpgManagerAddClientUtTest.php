<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerAddClientUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function gpgManager_AddClient_ClientAdded(): void
    {
        // Arrange
        $clientCode = 'test';
        $client = GpgClientComponentBuilder::make();
        $manager = GpgManagerComponentBuilder::make();

        // Act
        $manager->addClient($client, $clientCode);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
        $this->assertInstanceOf(GpgClient::class, $manager->getClient($clientCode));
    }
}
