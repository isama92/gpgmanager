<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;

class GpgClientDecryptUtTest extends GpgClientUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
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
