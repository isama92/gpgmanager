<?php

namespace Tests\Helpers\Common\GpgKeyPathHelper;

trait GpgKeyGetPathTrait
{
    /**
     * @return string
     */
    protected function getPrivateGpgKeyPath(): string
    {
        return GpgKeyPathHelper::getPrivateGpgKeyPath();
    }

    /**
     * @return string
     */
    protected function getPrivateGpgKeyPassphrase(): string
    {
        return GpgKeyPathHelper::getPrivateGpgKeyPassphrase();
    }

    /**
     * @return string
     */
    protected function getPublicGpgKeyPath(): string
    {
        return GpgKeyPathHelper::getPublicGpgKeyPath();
    }
}
