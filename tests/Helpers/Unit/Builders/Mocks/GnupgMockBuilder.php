<?php

namespace Tests\Helpers\Unit\Builders\Mocks;

use gnupg;

class GnupgMockBuilder extends MockBuilder
{
    /**
     * @inheritdoc
     */
    protected function setConcreteClassName()
    {
        $this->setClassName(gnupg::class);
    }
}
