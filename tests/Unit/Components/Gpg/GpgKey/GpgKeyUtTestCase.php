<?php

namespace Tests\Unit\Components\Gpg\GpgKey;

use Tests\Helpers\Common\GpgKeyPathHelper\GpgKeyGetPathTrait;
use Tests\Unit\Components\ComponentsUtTestCase;

abstract class GpgKeyUtTestCase extends ComponentsUtTestCase
{
    use GpgKeyGetPathTrait;
}
