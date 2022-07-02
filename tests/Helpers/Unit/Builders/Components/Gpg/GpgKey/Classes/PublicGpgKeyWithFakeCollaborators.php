<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgKey\Classes;

use Borzoni\SBFile\Components\SBFile\FileInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKey;
use gnupg;

class PublicGpgKeyWithFakeCollaborators extends PublicGpgKey
{
    /**
     * @var \Borzoni\SBFile\Components\SBFile\FileInterface
     */
    public FileInterface $fakeSBFile;

    /**
     * @param \gnupg                                          $gnupgMock
     * @param \Borzoni\SBFile\Components\SBFile\FileInterface $SBFileMock
     */
    public function __construct(gnupg $gnupgMock, FileInterface $SBFileMock)
    {
        $this->fakeSBFile = $SBFileMock;
        parent::__construct($gnupgMock);
    }

    /**
     * @param string $path
     * @param string $mode
     *
     * @return \Borzoni\SBFile\Components\SBFile\FileInterface
     */
    protected function createSBFile(string $path, string $mode): FileInterface
    {
        return $this->fakeSBFile;
    }
}
