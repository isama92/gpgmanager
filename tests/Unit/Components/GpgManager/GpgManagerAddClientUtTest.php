<?php

namespace Tests\Unit\Components\GpgManager;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Tests\Helpers\Unit\Builders\Components\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerAddClientUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
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
