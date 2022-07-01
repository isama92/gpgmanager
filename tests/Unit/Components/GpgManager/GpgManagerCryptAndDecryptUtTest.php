<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCryptAndDecryptUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\DecryptionFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgManager\Exceptions\GpgClientNotFoundException
     */
    public function encryptAndDecryptWithMultipleClients_WithValidValues_Success(): void
    {
        // Arrange
        $manager = GpgManagerComponentBuilder::make();
        $clientA = 'A';
        $messageA = 'aaaaaaaaaaaaaaaaa';
        $clientB = 'B';
        $messageB = 'bbbbbbbbbbbbbbbbb';

        // Act
        $manager->createWithPublicKey($this->getPublicGpgKeyPath(), $clientA);
        $manager->createWithBothKeys($this->getPrivateGpgKeyPath(), $this->getPublicGpgKeyPath(), $clientB, $this->getPrivateGpgKeyPassphrase());
        $encryptedMessageA = $manager->getClient($clientA)->encrypt($messageA);
        $encryptedMessageB = $manager->getClient($clientB)->encryptSign($messageB);

        $manager->getClient($clientA)->addPrivateKey($this->getPrivateGpgKeyPath(), $this->getPrivateGpgKeyPassphrase());
        $decryptedMessageA = $manager->getClient($clientA)->decrypt($encryptedMessageA);
        $decryptedMessageB = $manager->getClient($clientB)->decrypt($encryptedMessageB);

        // Assert
        $this->assertStringStartsWith('-----BEGIN PGP MESSAGE-----', $encryptedMessageA);
        $this->assertStringEndsWith('-----END PGP MESSAGE-----' . PHP_EOL, $encryptedMessageA);
        $this->assertStringStartsWith('-----BEGIN PGP MESSAGE-----', $encryptedMessageB);
        $this->assertStringEndsWith('-----END PGP MESSAGE-----' . PHP_EOL, $encryptedMessageB);
        $this->assertEquals($messageA, $decryptedMessageA);
        $this->assertEquals($messageB, $decryptedMessageB);
    }
}
