<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GpgClientMockBuilder;

class GpgManagerCreateWithBothKeysMockeryTest extends GpgManagerMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_CreateWithPrivateKey_ClientAdded(): void
    {
        // Arrange
        $privateKeyPath = 'privateKeyPath';
        $privateKeyPassphrase = 'privateKeyPassphrase';
        $publicKeyPath = 'publicKeyPath';
        $clientCode = 'clientCode';

        // Collaboration
        $gpgClientMock = (new GpgClientMockBuilder())->make();

        $gpgClientMock->shouldReceive('addBothKeys')
            ->once()
            ->with($privateKeyPath, $publicKeyPath, $privateKeyPassphrase)
            ->andReturnUndefined();

        // Act
        $manager = GpgManagerComponentBuilder::makeWithFakeCollaborators($gpgClientMock);
        $manager->createWithBothKeys($privateKeyPath, $publicKeyPath, $clientCode, $privateKeyPassphrase);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
