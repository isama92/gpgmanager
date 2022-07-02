<?php

namespace Tests\Unit\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManager;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\GpgManagerComponentBuilder;

class GpgManagerCreationUtTest extends GpgManagerUtTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function gpgManagerConstruct_ObjectCreated(): void
    {
        // Arrange
        $manager = GpgManagerComponentBuilder::make();

        // Assert
        $this->assertInstanceOf(GpgManager::class, $manager);
        $this->assertEquals([], $manager->getClients());
    }
}
