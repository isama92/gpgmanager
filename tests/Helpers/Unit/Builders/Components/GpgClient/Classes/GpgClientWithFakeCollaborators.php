<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgClient\Classes;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey;
use Borzoni\GpgManager\Components\GpgKey\PublicGpgKey;
use gnupg;

class GpgClientWithFakeCollaborators extends GpgClient
{
    /**
     * @var \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    public $fakePrivateGpgKey;

    /**
     * @var \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey
     */
    public $fakePublicGpgKey;

    /**
     * @param \gnupg                                                  $gnupgMock
     * @param \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey $privateGpgKeyMock
     * @param \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey  $publicGpgKeyMock
     */
    public function __construct(gnupg $gnupgMock, PrivateGpgKey $privateGpgKeyMock, PublicGpgKey $publicGpgKeyMock)
    {
        parent::__construct();
        $this->client = $gnupgMock;
        $this->fakePrivateGpgKey = $privateGpgKeyMock;
        $this->fakePublicGpgKey = $publicGpgKeyMock;
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PrivateGpgKey
     */
    protected function createPrivateGpgKey(): PrivateGpgKey
    {
        return $this->fakePrivateGpgKey;
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgKey\PublicGpgKey
     */
    protected function createPublicGpgKey(): PublicGpgKey
    {
        return $this->fakePublicGpgKey;
    }
}
