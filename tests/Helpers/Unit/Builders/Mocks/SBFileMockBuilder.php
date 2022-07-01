<?php

namespace Tests\Helpers\Unit\Builders\Mocks;

use Borzoni\SBFile\Components\SBFile\SBFile;

class SBFileMockBuilder extends MockBuilder
{
    /**
     * @inheritdoc
     */
    public function setConcreteClassName(): void
    {
        $this->setClassName(SBFile::class);
    }
}
