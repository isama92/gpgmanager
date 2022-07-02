<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GpgClientMockBuilder;

class GpgManagerCreateWithPublicKeyMockeryTest extends GpgManagerMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_CreateWithPrivateKey_ClientAdded(): void
    {
        // Arrange
        $publicKeyPath = 'publicKeyPath';
        $clientCode = 'clientCode';

        // Collaboration
        $gpgClientMock = (new GpgClientMockBuilder())->make();
        $gpgClientMock->shouldReceive('addPublicKey')
            ->once()
            ->with($publicKeyPath)
            ->andReturnUndefined();

        // Act
        $manager = GpgManagerComponentBuilder::makeWithFakeCollaborators($gpgClientMock);
        $manager->createWithPublicKey($publicKeyPath, $clientCode);

        // Assert
        $this->assertTrue($manager->clientExists($clientCode));
    }
}
