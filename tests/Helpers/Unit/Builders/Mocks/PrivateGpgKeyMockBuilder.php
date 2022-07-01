<?php

namespace Tests\Helpers\Unit\Builders\Mocks;

use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;

class PrivateGpgKeyMockBuilder extends MockBuilder
{
    /**
     * @inheritdoc
     */
    protected function setConcreteClassName()
    {
        $this->setClassName(PrivateGpgKey::class);
    }
}
