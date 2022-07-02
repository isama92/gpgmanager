<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;

class GpgClientEncryptUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     */
    public function encrypt_HappyPath_EncryptedStringReturned(): void
    {
        // Arrange
        $unencryptedString = $this->getUnencryptedFileContent();
        $client = GpgClientComponentBuilder::make();

        // Act
        $client->addPublicKey($this->getPublicGpgKeyPath());
        $encryptedString = $client->encrypt($unencryptedString);

        // Assert
        $this->assertStringStartsWith('-----BEGIN PGP MESSAGE-----', $encryptedString);
        $this->assertStringEndsWith('-----END PGP MESSAGE-----' . PHP_EOL, $encryptedString);
    }
}
