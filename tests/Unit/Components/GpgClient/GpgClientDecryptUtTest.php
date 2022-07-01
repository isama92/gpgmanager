<?php

namespace Tests\Unit\Components\GpgClient;

use Tests\Helpers\Unit\Builders\Components\GpgClient\GpgClientComponentBuilder;

class GpgClientDecryptUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\DecryptionFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     */
    public function decrypt_HappyPath_DecryptedStringReturned(): void
    {
        // Arrange
        $encryptedString = $this->getEncryptedFileContent();
        $expectedDecryptedString = $this->getUnencryptedFileContent();
        $client = GpgClientComponentBuilder::make();

        // Act
        $client->addPrivateKey($this->getPrivateGpgKeyPath(), $this->getPrivateGpgKeyPassphrase());
        $decryptedString = $client->decrypt($encryptedString);

        // Assert
        $this->assertEquals($expectedDecryptedString, $decryptedString);
    }
}
