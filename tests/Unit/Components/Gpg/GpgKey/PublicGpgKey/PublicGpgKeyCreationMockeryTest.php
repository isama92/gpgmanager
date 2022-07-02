<?php

namespace Tests\Unit\Components\Gpg\GpgKey\PublicGpgKey;

use Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey\PublicGpgKeyComponentBuilder;
use Tests\Helpers\Unit\Builders\Mocks\SBFileMockBuilder;
use Tests\Helpers\Unit\Builders\Mocks\GnupgMockBuilder;

class PublicGpgKeyCreationMockeryTest extends PublicGpgKeyMockeryTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function collaboration_objectCreated(): void
    {
        // Arrange
        $path = 'public key path';
        $keyContent = 'key content';
        $keyArgs = [
            'imported' => 0,
            'unchanged' => 0,
            'newuserids' => 0,
            'newsubkeys' => 0,
            'secretimported' => 0,
            'secretunchanged' => 0,
            'newsignatures' => 0,
            'skippedkeys' => 0,
            'fingerprint' => 'str',
        ];

        // Collaboration
        $SBFileMock = (new SBFileMockBuilder())->make();
        $SBFileMock->shouldReceive('read')
            ->once()
            ->withNoArgs()
            ->andReturn($keyContent);

        $gnupgMock = (new GnupgMockBuilder())->make();
        $gnupgMock->shouldReceive('import')
            ->once()
            ->with($keyContent)
            ->andReturn($keyArgs);

        // Act
        $key = PublicGpgKeyComponentBuilder::makeWithFakeCollaborators($gnupgMock, $SBFileMock);
        $key->readFromPath($path);

        // Assert
        $this->assertTrue(true);
    }
}
