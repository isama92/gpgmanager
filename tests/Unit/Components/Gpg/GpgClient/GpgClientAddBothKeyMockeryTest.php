<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientAddBothKeyMockeryTest extends GpgClientMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_HappyPath_KeySet(): void
    {
        // Arrange
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';

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
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);
        $privateKey = $client->getPrivateKey();
        $publicKey = $client->getPublicKey();

        // Assert
        $this->assertInstanceOf(PrivateGpgKey::class, $privateKey);
        $this->assertInstanceOf(PublicGpgKey::class, $publicKey);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_ReSetPrivateKey_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';

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
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);

        // Assert
        $this->expectException(PrivateGpgKeyAlreadySetException::class);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_ReSetPublicKey_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';

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
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);

        // Assert
        $this->expectException(PublicGpgKeyAlreadySetException::class);
        $client->addPublicKey($publicKeyPath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_ReSetBothKeys_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'publicPath';
        $publicKeyFingerprint = 'publicKeyFingerprint';
        $privateKeyPath = 'privatePath';
        $privateKeyFingerprint = 'privateKeyFingerprint';
        $privateKeyPassphrase = 'privateKeyPassaphrase';

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
        $gnupgMock->shouldReceive('addDecryptKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addSignKey')
            ->once()
            ->with($privateKeyFingerprint, $privateKeyPassphrase);
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);

        // Assert
        $this->expectException(PrivateGpgKeyAlreadySetException::class);
        $client->addBothKeys($privateKeyPath, $publicKeyPath, $privateKeyPassphrase);
    }
}
