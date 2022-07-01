<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgKey\Classes;

use Borzoni\SBFile\Components\SBFile\SBFile;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;
use gnupg;

class PrivateGpgKeyWithFakeCollaborators extends PrivateGpgKey
{
    /**
     * @var \Borzoni\SBFile\Components\SBFile\SBFile
     */
    public $fakeSBFile;

    /**
     * @param \gnupg                                       $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\SBFile $SBFileMock
     */
    public function __construct(gnupg $gnupgMock, SBFile $SBFileMock)
    {
        $this->fakeSBFile = $SBFileMock;
        parent::__construct($gnupgMock);
    }

    /**
     * @param string $path
     * @param string $mode
     *
     * @return \Borzoni\SBFile\Components\SBFile\SBFile
     */
    protected function createSBFile(string $path, string $mode): SBFile
    {
        return $this->fakeSBFile;
    }
}
