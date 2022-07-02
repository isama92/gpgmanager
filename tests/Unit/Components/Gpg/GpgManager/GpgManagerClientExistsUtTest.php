<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes\GpgManagerWithFakeStringClient;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerClientExistsUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function clientExists_ExistingClientCode_TrueReturned(): void
    {
        // Arrange
        $clientCode = GpgManagerWithFakeStringClient::TEST_CLIENT_CODE;
        $manager = GpgManagerComponentBuilder::makeWithFakeStringClient();

        // Act
        $exists = $manager->clientExists($clientCode);

        // Assert
        $this->assertTrue($exists);
    }

    /**
     * @test
     *
     * @return void
     */
    public function clientExists_UnexistingClientCode_TrueReturned(): void
    {
        // Arrange
        $clientCode = md5(rand());
        $manager = GpgManagerComponentBuilder::makeWithFakeStringClient();

        // Act
        $exists = $manager->clientExists($clientCode);

        // Assert
        $this->assertFalse($exists);
    }
}
