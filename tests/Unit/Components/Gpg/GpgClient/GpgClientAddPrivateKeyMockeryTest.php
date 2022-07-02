<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Borzoni\GpgManager\Components\Gpg\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKey;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\GpgClientComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PrivateGpgKeyMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\PublicGpgKeyMockBuilder;

class GpgClientAddPrivateKeyMockeryTest extends GpgClientMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_HappyPath_KeySet(): void
    {
        // Arrange
        $privateKeyPath = 'path';
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
        $privateKey = $client->getPrivateKey();

        // Assert
        $this->assertInstanceOf(PrivateGpgKey::class, $privateKey);
    }

    /**
     * @test
     *
     * @return void
     */
    public function collaboration_ReSetPrivateKey_ExceptionThrown(): void
    {
        // Arrange
        $privateKeyPath = 'path';
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
        $this->expectException(PrivateGpgKeyAlreadySetException::class);
        $client->addPrivateKey($privateKeyPath, $privateKeyPassphrase);
    }
}
