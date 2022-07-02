<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\Gpg\GpgManager\Exceptions\GpgClientNotFoundException;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes\GpgManagerWithFakeStringClient;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerGetClientUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function getClient_CorrectClientCode_ReturnedValueIsOk(): void
    {
        // Arrange
        $manager = GpgManagerComponentBuilder::makeWithFakeStringClient();
        $clientCode = GpgManagerWithFakeStringClient::TEST_CLIENT_CODE;

        // Act
        $client = $manager->getClient($clientCode);

        // Assert
        $this->assertInstanceOf(GpgClient::class, $client);
    }

    /**
     * @test
     *
     * @return void
     */
    public function getClient_IncorrectClientCode_ExceptionThrown(): void
    {
        // Arrange
        $manager = GpgManagerComponentBuilder::makeWithFakeStringClient();
        $clientCode = md5(rand());

        // Act and Assert
        $this->expectException(GpgClientNotFoundException::class);
        $manager->getClient($clientCode);
    }
}
