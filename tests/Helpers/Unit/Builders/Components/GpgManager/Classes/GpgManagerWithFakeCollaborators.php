<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgManager\Classes;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgManager\GpgManager;

class GpgManagerWithFakeCollaborators extends GpgManager
{
    /**
     * @var \Borzoni\GpgManager\Components\GpgClient\GpgClient
     */
    public $fakeGpgClient;

    /**
     * @param \Borzoni\GpgManager\Components\GpgClient\GpgClient $fakeGpgClient
     */
    public function __construct(GpgClient $fakeGpgClient)
    {
        $this->fakeGpgClient = $fakeGpgClient;
        parent::__construct();
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgClient\GpgClient
     */
    protected function createGpgClient(): GpgClient
    {
        return $this->fakeGpgClient;
    }
}
