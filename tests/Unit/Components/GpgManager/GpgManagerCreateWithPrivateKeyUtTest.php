<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreateWithPrivateKeyUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
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
