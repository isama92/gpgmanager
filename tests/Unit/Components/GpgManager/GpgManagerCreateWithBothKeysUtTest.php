<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithBothKeysUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
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
