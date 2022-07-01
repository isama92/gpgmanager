<?php

namespace Tests\Helpers\Unit\Builders\Components\GpgManager;

use Borzoni\GpgManager\Components\GpgClient\GpgClient;
use Borzoni\GpgManager\Components\GpgManager\GpgManager;
use Tests\Helpers\Unit\Builders\Components\GpgManager\Classes\GpgManagerWithFakeCollaborators;
use Tests\Helpers\Unit\Builders\Components\GpgManager\Classes\GpgManagerWithFakeStringClient;

class GpgManagerComponentBuilder
{
    /**
     * @return \Borzoni\GpgManager\Components\GpgManager\GpgManager
     */
    public static function make(): GpgManager
    {
        return new GpgManager();
    }

    /**
     * @return \Borzoni\GpgManager\Components\GpgManager\GpgManager
     */
    public static function makeWithFakeStringClient(): GpgManager
    {
        return new GpgManagerWithFakeStringClient();
    }

    /**
     * @param \Borzoni\GpgManager\Components\GpgClient\GpgClient $fakeGpgClient
     *
     * @return \Borzoni\GpgManager\Components\GpgManager\GpgManager
     */
    public static function makeWithFakeCollaborators(GpgClient $fakeGpgClient): GpgManager
    {
        return new GpgManagerWithFakeCollaborators($fakeGpgClient);
    }
}
