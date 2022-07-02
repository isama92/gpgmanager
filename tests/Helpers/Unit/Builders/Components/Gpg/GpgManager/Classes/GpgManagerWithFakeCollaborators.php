<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface;
use Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManager;

class GpgManagerWithFakeCollaborators extends GpgManager
{
    /**
     * @var \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    public GpgClientInterface $fakeGpgClient;

    /**
     * @param \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface $fakeGpgClient
     */
    public function __construct(GpgClientInterface $fakeGpgClient)
    {
        $this->fakeGpgClient = $fakeGpgClient;
        parent::__construct();
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface
     */
    protected function createGpgClient(): GpgClientInterface
    {
        return $this->fakeGpgClient;
    }
}
