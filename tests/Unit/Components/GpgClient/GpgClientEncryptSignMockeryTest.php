<?php

namespace Tests\Unit\Components\GpgClient;

use Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException;
use Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException;
use Tests\Helpers\Unit\Builders\Components\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientEncryptSignMockeryTest extends GpgClientMockeryTestCase
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
    public function collaboration_HappyPath_EncryptedTextIsCorrect(): void
    {
        // Arrange
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $unencryptedText = 'text';
        $expectedEncryptedText = 'encrypted_text';

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();
        $privateGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $privateGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($privateKeyFingerprint);

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();
        $publicGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $publicGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($publicKeyFingerprint);

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('encryptSign')
            ->once()
            ->with($unencryptedText)
            ->andReturn($expectedEncryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
        $client->addPublicKey($publicKeyPath);
        $encryptedText = $client->encryptSign($unencryptedText);

        // Assert
        $this->assertEquals($expectedEncryptedText, $encryptedText);
    }

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
    public function collaboration_FailsToEncryptSign_ExceptionThrown(): void
    {
        // Arrange
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $unencryptedText = 'text';
        $expectedEncryptedText = false;

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();
        $privateGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $privateGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($privateKeyFingerprint);

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();
        $publicGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $publicGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($publicKeyFingerprint);

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('encryptSign')
            ->once()
            ->with($unencryptedText)
            ->andReturn($expectedEncryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
        $client->addPublicKey($publicKeyPath);


        // Assert
        $this->expectException(EncryptionSignFailedException::class);
        $client->encryptSign($unencryptedText);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
     */
    public function collaboration_WithoutAddingPrivateGpgKey_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $unencryptedText = 'text';

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();
        $publicGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $publicGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($publicKeyFingerprint);

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPublicKey($publicKeyPath);

        // Assert
        $this->expectException(PrivateGpgKeyNotSetException::class);
        $client->encryptSign($unencryptedText);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\EncryptionSignFailedException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyNotSetException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PublicGpgKeyNotSetException
     */
    public function collaboration_WithoutAddingPublicGpgKey_ExceptionThrown(): void
    {
        // Arrange
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';
        $unencryptedText = 'text';

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();
        $privateGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $privateGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($privateKeyFingerprint);

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);

        // Assert
        $this->expectException(PublicGpgKeyNotSetException::class);
        $client->encryptSign($unencryptedText);
    }
}
