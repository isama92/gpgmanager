<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgClient\Classes;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface;
use Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface;
use gnupg;

class GpgClientWithFakeCollaborators extends GpgClient
{
    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface
     */
    public PrivateGpgKeyInterface $fakePrivateGpgKey;

    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface
     */
    public PublicGpgKeyInterface $fakePublicGpgKey;

    /**
     * @param \gnupg                                                                         $gnupgMock
     * @param \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface $privateGpgKeyMock
     * @param \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface   $publicGpgKeyMock
     */
    public function __construct(gnupg $gnupgMock, PrivateGpgKeyInterface $privateGpgKeyMock, PublicGpgKeyInterface $publicGpgKeyMock)
    {
        parent::__construct();
        $this->client = $gnupgMock;
        $this->fakePrivateGpgKey = $privateGpgKeyMock;
        $this->fakePublicGpgKey = $publicGpgKeyMock;
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PrivateGpgKey\PrivateGpgKeyInterface
     */
    protected function createPrivateGpgKey(): PrivateGpgKeyInterface
    {
        return $this->fakePrivateGpgKey;
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgKey\PublicGpgKey\PublicGpgKeyInterface
     */
    protected function createPublicGpgKey(): PublicGpgKeyInterface
    {
        return $this->fakePublicGpgKey;
    }
}
