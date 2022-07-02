<?php

namespace Tests\Unit\Components\Gpg\GpgClient;

use Tests\Helpers\Common\FileHelper\FileHelperTrait;
use Tests\Helpers\Common\GpgKeyPathHelper\GpgKeyGetPathTrait;
use Tests\Unit\Components\ComponentsUtTestCase;

abstract class GpgClientUtTestCase extends ComponentsUtTestCase
{
    use GpgKeyGetPathTrait;
    use FileHelperTrait;
}
