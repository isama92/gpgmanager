<?php

namespace Tests\Helpers\Unit\Builders\Mocks;

use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;

class PublicGpgKeyMockBuilder extends MockBuilder
{
    /**
     * @inheritdoc
     */
    protected function setConcreteClassName()
    {
        $this->setClassName(PublicGpgKey::class);
    }
}
