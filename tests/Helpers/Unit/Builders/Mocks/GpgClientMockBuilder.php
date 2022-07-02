<?php

namespace Tests\Helpers\Unit\Builders\Mocks;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;

class GpgClientMockBuilder extends MockBuilder
{
    /**
     * @inheritdoc
     */
    protected function setConcreteClassName()
    {
        $this->setClassName(GpgClient::class);
    }
}
