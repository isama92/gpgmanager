<?php

namespace Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager;

use Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface;
use Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManager;
use Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManagerInterface;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes\GpgManagerWithFakeCollaborators;
use Tests\Helpers\Unit\Builders\Components\Gpg\GpgManager\Classes\GpgManagerWithFakeStringClient;

class GpgManagerComponentBuilder
{
    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManagerInterface
     */
    public static function make(): GpgManagerInterface
    {
        return new GpgManager();
    }

    /**
     * @return \Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManagerInterface
     */
    public static function makeWithFakeStringClient(): GpgManagerInterface
    {
        return new GpgManagerWithFakeStringClient();
    }

    /**
     * @param \Borzoni\GpgManager\Components\Gpg\GpgClient\GpgClientInterface $fakeGpgClient
     *
     * @return \Borzoni\GpgManager\Components\Gpg\GpgManager\GpgManagerInterface
     */
    public static function makeWithFakeCollaborators(GpgClientInterface $fakeGpgClient): GpgManagerInterface
    {
        return new GpgManagerWithFakeCollaborators($fakeGpgClient);
    }
}
