<?php

namespace Tests\Unit\FactoryMethods\Gnupg;

use Borzoni\GpgManager\FactoryMethods\Gnupg\GnupgFactoryMethod;
use gnupg;

class BuildGnupgFactoryMethodUtTest extends GnupgFactoryMethodUtTestCase
{
    use GnupgFactoryMethod;

    /**
     * @test
     *
     * @return void
     */
    public function staticCreate_ReturnCorrectInstance(): void
    {
        // Act
        $gnupg = $this::staticCreateGnupg();

        // Assert
        $this->assertInstanceOf(gnupg::class, $gnupg);
    }

    /**
     * @test
     *
     * @return void
     */
    public function create_ReturnCorrectInstance(): void
    {
        // Act
        $gnupg = $this->createGnupg();

        // Assert
        $this->assertInstanceOf(gnupg::class, $gnupg);
    }
}
