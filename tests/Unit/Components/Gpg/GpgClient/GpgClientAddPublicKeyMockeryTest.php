<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PublicGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientAddPublicKeyMockeryTest extends GpgClientMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_HappyPath_KeySet(): void
    {
        // Arrange
        $publicKeyPath = 'path';
        $publicKeyFingerprint = 'publicKeyFingerprint';

        // Collaboration
        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();
        $publicGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $publicGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($publicKeyFingerprint);

        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPublicKey($publicKeyPath);
        $publicKey = $client->getPublicKey();

        // Assert
        $this->assertInstanceOf(PublicGpgKey::class, $publicKey);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_ReSetPublicKey_ExceptionThrown(): void
    {
        // Arrange
        $publicKeyPath = 'path';
        $publicKeyFingerprint = 'publicKeyFingerprint';

        // Collaboration
        $publicGpgKeyMock = (new PublicGpgKeyMockBuilder())->make();
        $publicGpgKeyMock->shouldReceive('readFromPath')
            ->once();
        $publicGpgKeyMock->shouldReceive('getFingerprint')
            ->once()
            ->withNoArgs()
            ->andReturn($publicKeyFingerprint);

        $privateGpgKeyMock = (new PrivateGpgKeyMockBuilder())->make();

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('addEncryptKey')
            ->once()
            ->with($publicKeyFingerprint);

        // Act
        $client = GpgClientComponentBuilder::makeWithFakeCollaborators($gnupgMock, $privateGpgKeyMock, $publicGpgKeyMock);
        $client->addPublicKey($publicKeyPath);

        // Assert
        $this->expectException(PublicGpgKeyAlreadySetException::class);
        $client->addPublicKey($publicKeyPath);
    }
}
