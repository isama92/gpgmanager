<?php

namespace Tests\Unit\Components\GpgManager;

use Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException;
use Tests\Helpers\Unit\Builders\Components\GpgManager\Classes\GpgManagerWithFakeStringClient;
use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerDeleteClientUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function deleteClient_CorrectClientCode_ClientDeleted(): void
    {
        // Arrange
        $clientCode = GpgManagerWithFakeStringClient::TEST_CLIENT_CODE;
        $manager = GpgManagerComponentBuilder::makeWithFakeStringClient();

        // Act
        $manager->deleteClient($clientCode);
        $exists = $manager->clientExists($clientCode);

        // Assert
        $this->assertFalse($exists);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function deleteClient_IncorrectClientCode_ExceptionThrown(): void
    {
        // Arrange
        $clientCode = 'test';
        $manager = GpgManagerComponentBuilder::make();

        // Act And Assert
        $this->expectException(GpgClientNotFoundException::class);
        $manager->deleteClient($clientCode);
    }
}
