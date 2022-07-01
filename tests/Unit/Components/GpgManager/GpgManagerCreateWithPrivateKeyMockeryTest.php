<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Unit\Builders\Components\GpgManager\GpgManagerComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GpgClientMockBuilder;

class GpgManagerCreateWithPrivateKeyMockeryTest extends GpgManagerMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException
     * @throws \Borzoni\SBFile\Components\SBFile\Exceptions\InvalidModeException
     * @throws \Borzoni\GpgManager\Components\GpgClient\Exceptions\PrivateGpgKeyAlreadySetException
     */
    public function collaboration_CreateWithPrivateKey_ClientAdded(): void
    {
        // Arrange
        $privateKeyPath = 'privateKeyPath';
        $privateKeyPassphrase = 'privateKeyPassphrase';
        $clientCode = 'clientCode';

        // Collaboration
        $gpgClientMock = (new GpgClientMockBuilder())->make();
        $gpgClientMock->shouldReceive('addPrivateKey')
            ->once()
            ->with($privateKeyPath, $privateKeyPassphrase)
            ->andReturnUndefined();

        // Act
        $manager = GpgManagerComponentBuilder::makeWithFakeCollaborators($gpgClientMock);
        $manager->createWithPrivateKey($privateKeyPath, $clientCode, $privateKeyPassphrase);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
