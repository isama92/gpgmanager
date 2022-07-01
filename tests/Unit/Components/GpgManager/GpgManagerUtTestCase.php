<?php

namespace Tests\Unit\Components\GpgManager;

use Tests\Helpers\Common\GpgKeyPathHelper\GpgKeyGetPathTrait;
use Tests\Unit\Components\ComponentsUtTestCase;

abstract class GpgManagerUtTestCase extends ComponentsUtTestCase
{
    use GpgKeyGetPathTrait;
}
