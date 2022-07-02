<?php

namespace Tests\Unit\Components\Gpg\GpgKey\PrivateGpgKey;

use Borzoni\SBFile\Components\SBFile\Exceptions\IOFileException;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey\PrivateGpgKeyComponentBuilder;

class PrivateGpgKeyCreationUtTest extends PrivateGpgKeyUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function createPrivateGpgKey_happyPath_returnWithRightProperties(): void
    {
        // Arrange
        $path = $this->getPrivateGpgKeyPath();
        $key = PrivateGpgKeyComponentBuilder::make();

        // Act
        $key->readFromPath($path);

        // Assert
        $this->assertIsInt($key->getImported());
        $this->assertIsInt($key->getUnchanged());
        $this->assertIsInt($key->getNewuserids());
        $this->assertIsInt($key->getNewsubkeys());
        $this->assertIsInt($key->getSecretimported());
        $this->assertIsInt($key->getSecretunchanged());
        $this->assertIsInt($key->getNewsignatures());
        $this->assertIsInt($key->getSkippedkeys());
        $this->assertIsString($key->getFingerprint());
    }

    /**
     * @test
     *
     * @return void
     */
    public function createPrivateGpgKey_badPath_shouldThrowException(): void
    {
        // Arrange
        $path = 'random/random.pgp';
        $key = PrivateGpgKeyComponentBuilder::make();

        // Act and Assert
        $this->expectException(IOFileException::class);
        $key->readFromPath($path);
    }
}
