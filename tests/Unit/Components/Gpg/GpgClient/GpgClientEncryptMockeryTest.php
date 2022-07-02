<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\EncryptionFailedException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyNotSetException;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientEncryptMockeryTest extends GpgClientMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_HappyPath_EncryptedTextIsCorrect(): void
    {
        // Arrange
        $publicKeyPath = 'path';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $unencryptedText = 'text';
        $expectedEncryptedText = 'encrypted_text';

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
        $gnupgMock->shouldReceive('encrypt')
            ->once()
            ->with($unencryptedText)
            ->andReturn($expectedEncryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPublicKey($publicKeyPath);
        $encryptedText = $client->encrypt($unencryptedText);

        // Assert
        $this->assertEquals($expectedEncryptedText, $encryptedText);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_FailsToEncrypt_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'path';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $unencryptedText = 'text';
        $expectedEncryptedText = false;

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
        $gnupgMock->shouldReceive('encrypt')
            ->once()
            ->with($unencryptedText)
            ->andReturn($expectedEncryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPublicKey($publicKeyPath);


        // Assert
        $this->expectException(EncryptionFailedException::class);
        $client->encrypt($unencryptedText);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_WithoutAddingPublicGpgKey_ExceptionThrown(): void
    {
        // Arrange
        $unencryptedText = 'text';

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();

        $gnupgMock = (new GnupgMockBuilder())->make();

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);

        // Assert
        $this->expectException(PublicGpgKeyNotSetException::class);
        $client->encrypt($unencryptedText);
    }
}
