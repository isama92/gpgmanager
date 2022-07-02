<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithBothKeysUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createWithBothKeys_WithValidValues_ClientAdded(): void
    {
        // Arrange
        $privateGpgKeyPath = $this->getPrivateGpgKeyPath();
        $publicGpgKeyPath = $this->getPublicGpgKeyPath();
        $clientCode = 'test';
        $manager = GpgManagerComponentBuilder::make();

        // Act
        $manager->createWithBothKeys($privateGpgKeyPath, $publicGpgKeyPath, $clientCode, $this->getPrivateGpgKeyPassphrase());

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
