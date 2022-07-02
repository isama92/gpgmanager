<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithPublicKeyUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createWithPublicKey_WithValidValues_ClientAdded(): void
    {
        // Arrange
        $publicGpgKeyPath = $this->getPublicGpgKeyPath();
        $clientCode = 'test';
        $manager = GpgManagerComponentBuilder::make();

        // Act
        $manager->createWithPublicKey($publicGpgKeyPath, $clientCode);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
