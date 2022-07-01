<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithPublicKeyUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
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
