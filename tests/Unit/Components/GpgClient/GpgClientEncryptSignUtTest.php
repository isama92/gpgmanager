<?php

namespace Tests\Unit\Components\GpgClient;

use Tests\Helpers\Unit\Builders\Components\GpgClient\GpgClientComponentBuilder;

class GpgClientEncryptSignUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
     */
    public function encrypt_HappyPath_EncryptedStringReturned(): void
    {
        // Arrange
        $unencryptedString = $this->getUnencryptedFileContent();
        $client = GpgClientComponentBuilder::make();

        // Act
        $client->addPrivateKey($this->getPrivateGpgKeyPath(), $this->getPrivateGpgKeyPassphrase());
        $client->addPublicKey($this->getPublicGpgKeyPath());
        $encryptedString = $client->encryptSign($unencryptedString);

        // Assert
        $this->assertStringStartsWith('-----BEGIN PGP MESSAGE-----', $encryptedString);
        $this->assertStringEndsWith('-----END PGP MESSAGE-----' . PHP_EOL, $encryptedString);
    }
}
