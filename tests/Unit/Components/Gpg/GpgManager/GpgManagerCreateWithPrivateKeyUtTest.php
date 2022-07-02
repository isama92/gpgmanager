<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithPrivateKeyUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createWithPrivateKey_WithValidValues_ClientAdded(): void
    {
        // Arrange
        $privateGpgKeyPath = $this->getPrivateGpgKeyPath();
        $privateGpgKeyPassphrase = $this->getPrivateGpgKeyPassphrase();
        $clientCode = 'test';
        $manager = GpgManagerComponentBuilder::make();

        // Act
        $manager->createWithPrivateKey($privateGpgKeyPath, $clientCode, $privateGpgKeyPassphrase);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
