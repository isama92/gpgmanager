<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\DecryptionFailedException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyNotSetException;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientDecryptMockeryTest extends GpgClientMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_HappyPath_DecryptedTextIsCorrect(): void
    {
        // Arrange
        $privateKeyPath = 'path';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';
        $encryptedText = 'text';
        $expectedDecryptedText = 'decrypted_text';

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
        $gnupgMock->shouldReceive('decrypt')
            ->once()
            ->with($encryptedText)
            ->andReturn($expectedDecryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
        $decryptedText = $client->decrypt($encryptedText);

        // Assert
        $this->assertEquals($expectedDecryptedText, $decryptedText);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_FailsToDecrypt_ExceptionThrown(): void
    {
        // Arrange
        $privateKeyPath = 'path';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';
        $encryptedText = 'text';
        $expectedDecryptedText = false;

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
        $gnupgMock->shouldReceive('decrypt')
            ->once()
            ->with($encryptedText)
            ->andReturn($expectedDecryptedText);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);


        // Assert
        $this->expectException(DecryptionFailedException::class);
        $client->decrypt($encryptedText);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_WithoutAddingPrivateGpgKey_ExceptionThrown(): void
    {
        // Arrange
        $encryptedText = 'text';

        // Collaboration
        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();

        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();

        $gnupgMock = (new GnupgMockBuilder())->make();

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);

        // Assert
        $this->expectException(PrivateGpgKeyNotSetException::class);
        $client->decrypt($encryptedText);
    }
}
