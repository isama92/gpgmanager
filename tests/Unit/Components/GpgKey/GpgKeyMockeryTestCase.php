<?php

namespace Tests\Unit\Components\GpgKey;

use Tests\Helpers\Common\GpgKeyPathHelper\GpgKeyGetPathTrait;
use Tests\Unit\Components\ComponentsMockeryTestCase;

abstract class GpgKeyMockeryTestCase extends ComponentsMockeryTestCase
{
    use GpgKeyGetPathTrait;
}
